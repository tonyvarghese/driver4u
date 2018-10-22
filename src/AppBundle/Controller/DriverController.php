<?php

namespace AppBundle\Controller;

use AppBundle\Entity\DriverDetails;
use AppBundle\Entity\User;
use AppBundle\Entity\UserAddresses;
use AppBundle\Entity\UserContactNos;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DriverController extends Controller
{

    /**
     * @Route("admin/driver/newest", name="driver_newest")
     * @Method({"GET", "POST"})
     */
    public function AddDriverAction(Request $request)
    {

        $user= new User();
        if ($request->request->has('submit')) {
            //for get the data
            $name = $request->get('name');
            $email = $request->get('email');



            $user->setFullName($name);
            $user->setEmail($email);
            $user->setPassword('');
            $user->setStatus(0);
            $user->setRoles([]);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $uid = $user->getId();

            $this->insertDriver($request, $uid);
        }



//        //if ($request->query->has('submit'))
//        if ($request->request->has('submit'))
//        {
//
//
//            $useraddress = new UserAddresses();
//            if ($request->request->has('submit'))
//            {
//                $address = $request->get('address');
//                $useraddress->setAddress($address);
//                $em = $this->getDoctrine()->getManager();
//                $em->persist($driver);
//                $em->flush();
//            }
//
//            $usercontact = new UserContactNos();
//            if ($request->request->has('submit'))
//            {
//                $usercontactno = $request->get('phoneno');
//                $usercontact->setContactNumber($usercontactno);
//                $em = $this->getDoctrine()->getManager();
//                $em->persist($driver);
//                $em->flush();
//            }
//        }


        return $this->render("admin/pages/driver/new.html.twig");
    }

    public function insertDriver($request, $uid){

        $driver = new DriverDetails();

        //for get the data
        $age = $request->get('age');
        $drivertype= $request->get('drivertype');
        $expertise = $request->get('expertise');
        $pccsubmitted = $request->get('pccsubmitted');
        $documenttype = $request->get('documenttype');
        $documentnumber = $request->get('documentnumber');
        $driverassignment = $request->get('driverassignment');
        $note = $request->get('note');
        //call the setters

        $driver->setAge($age);
        $driver->setDriverType($drivertype);
        $driver->setExpertise($expertise);
        $driver->setPccSubmitted($pccsubmitted);
        $driver->setDriverType($documenttype);
        $driver->setDocNumber($documentnumber);
        $driver->setDriverAssignment($driverassignment);
        $driver->setNote($note);
        $driver->setUid($uid);





        //create entity manager ,save data to table
        $em = $this->getDoctrine()->getManager();
        $em->persist($driver);
        $em->flush();
    }
    
     
}
