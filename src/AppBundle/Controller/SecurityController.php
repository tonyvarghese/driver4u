<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Controller used to manage the application security.
 * See https://symfony.com/doc/current/cookbook/security/form_login_setup.html.
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class SecurityController extends Controller {

    /**
     * @Route("/", name="security_login")
     */
    public function loginAction(AuthenticationUtils $helper) {
        return $this->render('security/login.html.twig', [
                    // last username entered by the user (if any)
                    'last_username' => $helper->getLastUsername(),
                    // last authentication error (if any)
                    'error' => $helper->getLastAuthenticationError(),
        ]);
    }

    /**
     * This is the route the user can use to logout.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically. See logout in app/config/security.yml
     *
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction() {
        throw new \Exception('This should never be reached!');
    }

    /**
     * @Route("/change-password", name="security_changepassword")
     */
    public function changePasswordAction(UserPasswordEncoderInterface $encoder, Request $request) {
        if ($request->request->has('submit')) {

            $user = $this->getUser();
            
            $entityManager = $this->getDoctrine()->getManager();
            $userObj = $entityManager->getRepository(User::class)->find($user->getId());
            
            $oldpassword = $request->request->get('oldpassword');

            
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $passwordcheck = $encoder->isPasswordValid($user->getPassword(), $oldpassword, $user->getSalt());


            if ($passwordcheck) {
                if ($request->request->get('newpassword') == $request->request->get('confirmpassword')) {
                    $newpassword = $request->request->get('newpassword');
                    //$encoded = $encoder->encodePassword($user, $newpassword);
                    $encodedPwd = $encoder->encodePassword($newpassword, $user->getSalt());
                    
                    $userObj->setPassword($encodedPwd);
                    $entityManager->flush();
                    
                    $this->addFlash('success', 'Password changed');
                    return $this->redirectToRoute('security_changepassword');
                } else {

                    $this->addFlash('error', 'Confirm Password mismatch');
                    return $this->redirectToRoute('security_changepassword');
                }
            } else {
                $this->addFlash('error', 'Current password is incorrect');
                return $this->redirectToRoute('security_changepassword');
            }




//        
//         $user = $this->getUser();
//          $factory = $this->get('security.encoder_factory');
//          $encoder = $factory->getEncoder($user);
//           $oldpassword = $request->request->get('oldpassword');
//          $encodedPwd = $encoder->encodePassword($oldpassword, $user->getSalt());
//          var_dump($encodedPwd); die();
//          
//          
//         $user = new AppBundle\Entity\User();
//         $username = $user->getUsername();
//         $oldpassword = $request->request->get('oldpassword');
//         $encoded = $encoder->encodePassword($user, $oldpassword);
//         var_dump($encoded); 
//         var_dump($user->getPassword()); die;
//         
//      //   $request->request->get('password'));
//         
//         $user = new App\Entity\User();
//         $user->setFullName($request->request->get('password'));
        }
        return $this->render('security/changepassword.html.twig');
    }

}
