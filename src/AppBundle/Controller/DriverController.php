<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Drivers;


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
     * @Route("admin/drivers", name="driver_view")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $drivers = $em->getRepository(Drivers::class)->findAll();

        return $this->render('admin/pages/driver/index.html.twig', ['drivers' => $drivers]);
    }
    /**
     * @Route("admin/driver/new", name="driver_new")
     * @Method({"GET", "POST"})
     */
    public function AddDriverAction(Request $request)
    {
        $driver = new Drivers();
        if ($request->request->has('submit')) {
            //for get the data
            $fullname = $request->get('name');
            $email = $request->get('email');
            $phone = $request->get('phone');
            $address = $request->get('address');
            $age = $request->get('age');
            $drivertype = $request->get('drivertype');
            $expertise = $request->get('expertise');
            $pccsubmitted = $request->get('pcc');
            $document = $request->get('document');
            $docnumber = $request->get('docnumber');
            $driverassignment = $request->get('driverassignment');
            $note = $request->get('note');


            $driver->setFullName($fullname);
            $driver->setEmail($email);
            $driver->setPhone($phone);
            $driver->setAddress($address);
            $driver->setAge($age);
            $driver->setDriverType($drivertype);
            $driver->setExpertise($expertise);
            $driver->setPccSubmitted($pccsubmitted);
            $driver->setDocument($document);
            $driver->setDocNumber($docnumber);
            $driver->setDriverAssignment($driverassignment);
            $driver->setNote($note);

            $em = $this->getDoctrine()->getManager();
            $em->persist($driver);
            $em->flush();

            $this->addFlash('success', 'Driver created Successfully');
            return $this->redirectToRoute('driver_new');

        }
        return $this->render("admin/pages/driver/new.html.twig");
    }
}
