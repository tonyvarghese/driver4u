<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Driver;
use AppBundle\Entity\DriverAddress;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DriverController extends Controller {

    public function driverType() {
        return [0 => "", 1 => "Full Time", 2 => "Part time"];
    }

    public function expertise() {
        return [0 => "", 1 => "Manual", 2 => "Automatic", 3 => "Premium"];
    }

    public function pcc() {
        return [0 => "", 1 => "Yes", 2 => "No"];
    }

    public function document() {
        return [0 => "", 1 => "Driving Licence", 2 => "Pan Card", 3 => "Aadhar"];
    }

    public function driverAssignment() {
        return [0 => "", 1 => "Monthly", 2 => "On Demand"];
    }

    public function jsonToString($json, $values) {
        $data = [];
        $jsonObj = json_decode($json);

        if ($jsonObj) {
            foreach ($jsonObj as $item) {
                $data[] = $values[$item];
            }

            return implode(',', $data);
        }

        return "";
    }

    /**
     * @Route("admin/drivers", name="driver_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $drivers = $em->getRepository(Driver::class)->findAll();

        $data = [];
        foreach ($drivers as $key => $value) {
            $data[$key]['id'] = $value->getId();
            $data[$key]['fullName'] = $value->getFullName();
            $data[$key]['email'] = $value->getEmail();
            $data[$key]['location'] = $value->getLocation();
            $data[$key]['addresses'] = $value->getAddresses();
            $data[$key]['phones'] = json_decode($value->getPhone());
            $data[$key]['doj'] = ($value->getDoj());
        }

        $paginator = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
                $data, /* query NOT result */ $request->query->getInt('page', 1)/* page number */, 10/* limit per page */
        );



        return $this->render('admin/pages/driver/index.html.twig', ['drivers' => $pagination]);
    }

    public function addAddress($request, $UserId) {

            $em = $this->getDoctrine()->getManager();
        
            $q = $em->createQuery("delete from AppBundle\Entity\DriverAddress a where a.userId = $userId");
            $numDeleted = $q->execute();

            $driver = $em->getRepository(Driver::class)->find($userId);
        
        
        $count = count($request->request->get('street'));
        
        for($i = 0; $i < $count; $i++){
            $house = $request->request->get('house-number')[$i];
            $street = $request->request->get('street')[$i];
            $city = $request->request->get('city')[$i];
            $landmark = $request->request->get('landmark')[$i];
            
            $address = new DriverAddress();
            
            //$address->setUserType(1);
            $address->setUserId($driver);
            $address->setHouseNo($house);
            $address->setStreet($street);
            $address->setCity($city);
            $address->setLandmark($landmark);
            
            $em->persist($address);
            $em->flush();            
        }
        
    }
    
    /**
     * @Route("admin/driver/new", name="driver_new")
     * @Method({"GET", "POST"})
     */
    public function AddDriverAction(Request $request) {
        $driver = new Driver();
        if ($request->request->has('submit')) {

            $driver->setFullName($request->request->get('name'));
            $driver->setEmail($request->request->get('email'));
            $driver->setPhone(json_encode($request->request->get('phone')));
            $driver->setLocation($request->request->get('location'));
            $driver->setAge($request->request->get('age'));
            $driver->setDoj(new \DateTime($request->request->get('doj')));
            $driver->setDriverType(json_encode($request->request->get('drivertype')));
            $driver->setExpertise(json_encode($request->request->get('expertise')));
            $driver->setPccSubmitted($request->request->get('pcc'));
            $driver->setDocument(json_encode($request->request->get('document')));
            if ($request->request->get('docnumber') != '')
                $driver->setDocNumber($request->request->get('docnumber'));
            $driver->setDriverAssignment(json_encode($request->request->get('driverassignment')));
            $driver->setNote($request->request->get('note'));
            $driver->setStatus(1);
            $driver->setCreatedAt(new \DateTime("now"));

            $validator = $this->get('validator');
            $errors = $validator->validate($driver);

            if (count($errors) > 0) {

                $errorsString = (string) $errors;

                return new Response($errorsString);
            }
            //for get the data

            $em = $this->getDoctrine()->getManager();
            $em->persist($driver);
            $em->flush();

            $this->addAddress($request, $driver->getId());

            $this->addFlash('success', 'Driver created Successfully');
            return $this->redirectToRoute('driver_new');
        }
        return $this->render("admin/pages/driver/new.html.twig");
    }

    /**
     * @Route("admin/driver/edit/{id}", name="driver_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id) {
        $driver = new Driver();
        if ($request->request->has('submit')) {

            $entityManager = $this->getDoctrine()->getManager();
            $driver = $entityManager->getRepository(Driver::class)->find($id);
            if (!$driver) {
                throw $this->createNotFoundException(
                        'No user found for id ' . $id
                );
            }

            $driver->setFullName($request->request->get('name'));
            $driver->setEmail($request->request->get('email'));
            $driver->setLocation($request->request->get('location'));
            $driver->setPhone(json_encode($request->request->get('phone')));
            $driver->setAge($request->request->get('age'));
            $driver->setDriverType(json_encode($request->request->get('drivertype')));
            $driver->setExpertise(json_encode($request->request->get('expertise')));
            $driver->setPccSubmitted($request->request->get('pcc'));
            $driver->setDocument(json_encode($request->request->get('document')));
            $driver->setDocNumber($request->request->get('docnumber'));
            $driver->setDriverAssignment(json_encode($request->request->get('driverassignment')));
            $driver->setNote($request->request->get('note'));
            $driver->setStatus(1);

            $validator = $this->get('validator');
            $errors = $validator->validate($driver);

            if (count($errors) > 0) {

                $errorsString = (string) $errors;

                return new Response($errorsString);
            }

            $entityManager->flush();
            
            $this->addAddress($request, $id);

            $this->addFlash('success', 'Driver Updated Successfully');            
            
            return $this->redirectToRoute('driver_edit', ['id' => $id]);
        }
        $repository = $this->getDoctrine()->getRepository(Driver::class);
        $driverObj = $repository->find($id);
        $data['name'] = $driverObj->getFullName();
        $data['email'] = $driverObj->getEmail();
        $data['location'] = $driverObj->getLocation();
        $data['addresses'] = $driverObj->getAddresses();
        $data['phone'] = json_decode($driverObj->getPhone());
        $data['age'] = $driverObj->getAge();
        $data['doj'] = $driverObj->getDoj();
        $data['drivertype'] = json_decode($driverObj->getDriverType());
        $data['expertise'] = json_decode($driverObj->getExpertise());
        $data['pcc'] = $driverObj->getPccSubmitted();
        $data['document'] = json_decode($driverObj->getDocument());
        $data['docnumber'] = $driverObj->getDocNumber();
        $data['driverassignment'] = json_decode($driverObj->getDriverAssignment());
        $data['note'] = $driverObj->getNote();
        $data['status'] = $driverObj->getStatus();

        return $this->render('admin/pages/driver/edit.html.twig', ['data' => $data]);
    }

    /**
     * @Route("admin/driver/view/{id}", name="driver_view")
     * @Method({"GET", "POST"})
     */
    public function viewAction($id) {
        //$driver= $this->getDoctrine()->getRepository('AppBundle:Driver')->find($id);

        $repository = $this->getDoctrine()->getRepository(Driver::class);
        $driverObj = $repository->find($id);
        $data['name'] = $driverObj->getFullName();
        $data['email'] = $driverObj->getEmail();
        $data['location'] = $driverObj->getLocation();
        $data['addresses'] = $driverObj->getAddresses();
        $data['phone'] = json_decode($driverObj->getPhone());
        $data['age'] = $driverObj->getAge();
        $data['doj'] = $driverObj->getDoj();
        $data['drivertype'] = $this->jsonToString($driverObj->getDriverType(), $this->driverType());
        $data['expertise'] = ($this->jsonToString($driverObj->getExpertise(), $this->expertise()));
        $data['pcc'] = $this->pcc()[$driverObj->getPccSubmitted()];
        $data['document'] = ($this->jsonToString($driverObj->getDocument(), $this->document()));
        $data['docnumber'] = $driverObj->getDocNumber();
        $data['driverassignment'] = ($this->jsonToString($driverObj->getDriverAssignment(), $this->driverAssignment()));
        $data['note'] = $driverObj->getNote();
        $data['status'] = $driverObj->getStatus();


        return $this->render("admin/pages/driver/view.html.twig", ['driver' => $data]);
    }

    /**
     * @Route("admin/driver/delete/{id}", name="driver_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, Driver $driver) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($driver);
        $em->flush();
        //display the message
        $this->addFlash('success', 'Post Deleted Successfully');
        return $this->redirectToRoute('driver_index');
    }

}
