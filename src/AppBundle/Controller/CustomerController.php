<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\User;
use AppBundle\Entity\DriverDetails;
use AppBundle\Entity\CustomerDetails;


class CustomerController extends Controller
{
        /**
     * Creates a new Post entity.
     *
     * @Route("admin/customer/new", name="customer_new")
     * @Method({"GET", "POST"})
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function newAction(Request $request)
    {
        
        $user = new User();
        

        if ($request->request->has('submit')) {

            $user->setFullName($request->request->get('fullname'));
            $user->setEmail($request->request->get('email'));
            $user->setPassword('');
            $user->setStatus(0);
            $user->setRoles(["ROLE_CUSTOMER"]);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $uid = $user->getId();
            
            $this->insertCustomer($request, $uid);
            
            // Flash messages are used to notify the user about the result of the
            // actions. They are deleted automatically from the session as soon
            // as they are accessed.
            // See https://symfony.com/doc/current/book/controller.html#flash-messages
            $this->addFlash('success', 'Customer created_successfully');

            return $this->redirectToRoute('customer_new');
        }
        

        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        // this returns an array 
        $drivers = $qb->select(array('u.id', 'u.fullName'))
            ->from('AppBundle:DriverDetails', 'd')
            ->join('AppBundle:User', 'u')
            ->where('d.uid = u.id')
            //->andWhere('e.user = :userName')
//            ->setParameter('userName', 'scott')
            ->andWhere('u.roles like :roles') 
            ->setParameter('roles',  '%ROLE_DRIVER%')                
            ->orderBy('u.id', 'ASC')
            ->getQuery()
            ->getResult();    
        
  
        return $this->render('admin/pages/customer/new.html.twig', ['drivers' => $drivers]);
    }
    
    public function insertCustomer($request, $uid){
        $customer = new CustomerDetails();
        
        $customer->setUid($uid);
        $customer->setUsualTrip($request->request->get('usualTrip'));
        $customer->setPreferredDriver($request->request->get('driver'));

        $em = $this->getDoctrine()->getManager();
        $em->persist($customer);
        $em->flush();        
    }
}
