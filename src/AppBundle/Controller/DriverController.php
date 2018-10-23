<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Driver;


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
     * @Route("admin/drivers", name="driver_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $drivers = $em->getRepository(Driver::class)->findAll();

        $data = [];
        foreach ($drivers as $key => $value)
        {
            $data[$key]['id'] = $value->getId();
            $data[$key]['fullName'] = $value->getFullName();
            $data[$key]['email'] = $value->getEmail();
            $data[$key]['phone'] = json_decode($value->getPhone());
            $data[$key]['address'] = json_decode($value->getAddress());
        }

        //print_r($data); die;

        return $this->render('admin/pages/driver/index.html.twig',['drivers' => $data]);
    }
    /**
     * @Route("admin/driver/new", name="driver_new")
     * @Method({"GET", "POST"})
     */
    public function AddDriverAction(Request $request)
    {
        $driver = new Driver();
        if ($request->request->has('submit')) {
            //for get the data

            $driver->setFullName($request->request->get('name'));
            $driver->setEmail($request->request->get('email'));
            $driver->setAddress(json_encode($request->request->get('address')));
            $driver->setPhone(json_encode($request->request->get('phone')));
            $driver->setAge($request->request->get('age'));
            $driver->setDriverType($request->request->get('drivertype'));
            $driver->setExpertise($request->request->get('expertise'));
            $driver->setPccSubmitted($request->request->get('pcc'));
            $driver->setDocument($request->request->get('document'));
            if ($request->request->get('docnumber') != '')
            $driver->setDocNumber($request->request->get('docnumber'));
            $driver->setDriverAssignment($request->request->get('driverassignment'));
            $driver->setNote($request->request->get('note'));
            $driver->setStatus(1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($driver);
            $em->flush();

            $this->addFlash('success', 'Driver created Successfully');
            return $this->redirectToRoute('driver_new');

        }
        return $this->render("admin/pages/driver/new.html.twig");
    }

    /**
     * @Route("admin/driver/edit/{id}", name="driver_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $driver = new Driver();
        if ($request->request->has('submit'))
        {

            $entityManager = $this->getDoctrine()->getManager();
            $driver = $entityManager->getRepository(Driver::class)->find($id);
            if (!$driver) {
                throw $this->createNotFoundException(
                    'No customer found for id '.$id
                );
            }

            $driver->setFullName($request->request->get('name'));
            $driver->setEmail($request->request->get('email'));
            $driver->setAddress(json_encode($request->request->get('address')));
            $driver->setPhone(json_encode($request->request->get('phone')));
            $driver->setAge($request->request->get('age'));
            $driver->setDriverType($request->request->get('drivertype'));
            $driver->setExpertise($request->request->get('expertise'));
            $driver->setPccSubmitted($request->request->get('pcc'));
            $driver->setDocument($request->request->get('document'));
            $driver->setDocNumber($request->request->get('docnumber'));
            $driver->setDriverAssignment($request->request->get('driverassignment'));
            $driver->setNote($request->request->get('note'));
            $driver->setStatus(1);

            $this->addFlash('success', 'Driver Updated Successfully');
            $entityManager->flush();
            return $this->redirectToRoute('driver_edit', ['id' => $id]);
        }
        $repository = $this->getDoctrine()->getRepository(Driver::class);
        $driverObj = $repository->find($id);
        $data['name'] = $driverObj->getFullName();
        $data['email'] = $driverObj->getEmail();
        $data['address'] = json_decode($driverObj->getAddress());
        $data['phone'] = json_decode($driverObj->getPhone());
        $data['age'] = $driverObj->getAge();
        $data['drivertype'] = $driverObj->getDriverType();
        $data['expertise'] = $driverObj->getExpertise();
        $data['pcc'] = $driverObj->getPccSubmitted();
        $data['document'] = $driverObj->getDocument();
        $data['docnumber'] = $driverObj->getDocNumber();
        $data['driverassignment'] = $driverObj->getDriverAssignment();
        $data['note'] = $driverObj->getNote();
        $data['status'] = $driverObj->getStatus();

        return $this->render('admin/pages/driver/edit.html.twig', ['data' => $data]);
    }
    /**
     * @Route("admin/driver/view/{id}", name="driver_view")
     * @Method({"GET", "POST"})
     */
    public function viewAction($id)
    {
        //$driver= $this->getDoctrine()->getRepository('AppBundle:Driver')->find($id);

        $repository = $this->getDoctrine()->getRepository(Driver::class);
        $driverObj = $repository->find($id);
        $data['name'] = $driverObj->getFullName();
        $data['email'] = $driverObj->getEmail();
        $data['address'] = json_decode($driverObj->getAddress());
        $data['phone'] = json_decode($driverObj->getPhone());
        $data['age'] = $driverObj->getAge();
        $data['drivertype'] = $driverObj->getDriverType();
        $data['expertise'] = $driverObj->getExpertise();
        $data['pcc'] = $driverObj->getPccSubmitted();
        $data['document'] = $driverObj->getDocument();
        $data['docnumber'] = $driverObj->getDocNumber();
        $data['driverassignment'] = $driverObj->getDriverAssignment();
        $data['note'] = $driverObj->getNote();
        $data['status'] = $driverObj->getStatus();


        return $this->render("admin/pages/driver/view.html.twig",['driver'=>$data]);
    }

    /**
     * @Route("admin/driver/delete/{id}", name="driver_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, Driver $driver)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($driver);
        $em->flush();
        //display the message
        $this->addFlash('success','Post Deleted Successfully');
        return $this->redirectToRoute('driver_index');
    }

}
