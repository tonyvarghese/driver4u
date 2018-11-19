<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lead;
use AppBundle\Entity\Customer;
use AppBundle\Entity\CustomerAddress;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\DateTime;

class LeadController extends Controller
{

    public function statusValues()
    {
        return [0 => "", 1 => "Interested", 2 => "Not Interested", 3 => "Cancelled", 4 => "Converted"];
    }

    /**
     * @Route("admin/leads", name="lead_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //$leads = $em->getRepository(Lead::class)->findBy(['status' => '4']);
        
        $query = $em->createQuery('SELECT l FROM AppBundle\Entity\Lead l WHERE l.status <> 4');
        $leads = $query->getResult();        

        $data = [];
        foreach ($leads as $key => $value) {
            $data[$key]['id'] = $value->getId();
            $data[$key]['fullName'] = $value->getFullName();
            $data[$key]['email'] = $value->getEmail();
            $data[$key]['phone'] = json_decode($value->getPhone());
            $data[$key]['address'] = json_decode($value->getAddress());
            $data[$key]['location'] = $value->getLocation();
            $data[$key]['feedback'] = $value->getFeedback();
            $data[$key]['status'] = $this->statusValues()[$value->getStatus()];
            $data[$key]['followupDate'] = $value->getFollowupDate();
        }
//pagination

        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $data, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );



        return $this->render('admin/pages/lead/index.html.twig', ['leads' => $pagination]);
    }

    /**
     * @Route("admin/lead/new", name="lead_new")
     * @Method({"GET", "POST"})
     */
    public function addLeadAction(Request $request)
    {
        $lead = new Lead();
        if ($request->request->has('submit')) {
            //for get the data

            //$followupDate = date("Y-m-d H:i:s", strtotime($request->request->get('followup')));
            $currentTime = new \DateTime("now"); //date("Y-m-d H:i:s", time());

            $followupDate = new \DateTime($request->request->get('followup'));

            $lead->setFullName($request->request->get('name'));
            $lead->setEmail($request->request->get('email'));
            $lead->setAddress(json_encode($request->request->get('address')));
            $lead->setPhone(json_encode([$request->request->get('phone')]));
            $lead->setLocation($request->request->get('location'));
            $lead->setFeedback($request->request->get('feedback'));
            $lead->setStatus($request->request->get('status'));
            $lead->setFollowupDate($followupDate);
            $lead->setCreatedAt($currentTime);
            $lead->setUpdatedAt($currentTime);
//validator

            $validator = $this->get('validator');
            $errors = $validator->validate($lead);

            if (count($errors) > 0)
            {

                $errorsString = (string)$errors;

                return new Response($errorsString);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($lead);
            $em->flush();

            $this->addFlash('success', 'Lead created Successfully');
            return $this->redirectToRoute('lead_new');

        }
        return $this->render("admin/pages/lead/new.html.twig");
    }

    /**
     * @Route("admin/lead/edit/{id}", name="lead_edit")
     * @Method({"GET", "POST"})
     */
    public function editLeadAction(Request $request, $id)
    {
        $lead = new Lead();
        $followupDate = new \DateTime($request->request->get('followup'));

        if ($request->request->has('submit')) {

            $entityManager = $this->getDoctrine()->getManager();
            $lead = $entityManager->getRepository(Lead::class)->find($id);
            if (!$lead) {
                throw $this->createNotFoundException(
                    'No customer found for id ' . $id
                );
            }

            $lead->setFullName($request->request->get('name'));
            $lead->setEmail($request->request->get('email'));
            $lead->setAddress(json_encode($request->request->get('address')));
            $lead->setPhone(json_encode([$request->request->get('phone')]));
            $lead->setLocation($request->request->get('location'));
            $lead->setFeedback($request->request->get('feedback'));
            $lead->setStatus($request->request->get('status'));
            $lead->setFollowupDate($followupDate);
        //validation
            $validator = $this->get('validator');
            $errors = $validator->validate($lead);

            if (count($errors) > 0)
            {

                $errorsString = (string)$errors;

                return new Response($errorsString);
            }

            $this->addFlash('success', 'Lead Updated Successfully');
            $entityManager->flush();
            return $this->redirectToRoute('lead_edit', ['id' => $id]);
        }
        $repository = $this->getDoctrine()->getRepository(Lead::class);
        $leadObj = $repository->find($id);
        $data['name'] = $leadObj->getFullName();
        $data['email'] = $leadObj->getEmail();
        $data['address'] = json_decode($leadObj->getAddress());
        $data['phone'] = json_decode($leadObj->getPhone());
        $data['location'] = $leadObj->getLocation();
        $data['feedback'] = $leadObj->getFeedback();
        $data['status'] = $leadObj->getStatus();
        $data['followupDate'] = $leadObj->getFollowupDate();
        return $this->render('admin/pages/lead/edit.html.twig', ['data' => $data]);
    }

    /**
     * @Route("admin/lead/view/{id}", name="lead_view")
     * @Method({"GET", "POST"})
     */
    public function viewLeadAction($id)
    {
        //$driver= $this->getDoctrine()->getRepository('AppBundle:Driver')->find($id);

        $repository = $this->getDoctrine()->getRepository(Lead::class);
        $leadObj = $repository->find($id);
        $data['id'] = $leadObj->getId();
        $data['name'] = $leadObj->getFullName();
        $data['email'] = $leadObj->getEmail();
        $data['address'] = json_decode($leadObj->getAddress());
        $data['phone'] = json_decode($leadObj->getPhone());
        $data['location'] = $leadObj->getLocation();
        $data['status'] = $this->statusValues()[$leadObj->getStatus()];
        $data['feedback'] = $leadObj->getFeedback();
        $data['followupDate'] = $leadObj->getFollowupDate();
        $data['createdAt'] = $leadObj->getCreatedAt();


        return $this->render("admin/pages/lead/view.html.twig", ['lead' => $data]);
    }

    /**
     * @Route("admin/lead/delete/{id}", name="lead_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, Lead $leads)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($leads);
        $em->flush();
        //display the message
        $this->addFlash('success', 'Lead Deleted Successfully');
        return $this->redirectToRoute('lead_index');
    }
    

    /**
     * @Route("admin/lead/convert/{id}", name="lead_convert")
     * @Method({"GET", "POST"})
     */
    public function convertAction(Request $request, Lead $leadId)
    {        
        $this->addCustomer($leadId);
        
//        $em = $this->getDoctrine()->getManager();
//        $em->remove($lead);
//        $em->flush();

            $entityManager = $this->getDoctrine()->getManager();
            $lead = $entityManager->getRepository(Lead::class)->find($leadId);
            if (!$lead) {
                throw $this->createNotFoundException(
                    'No customer found for id ' . $id
                );
            }

            $lead->setStatus(4);
            $entityManager->flush();
            
        //display the message
        $this->addFlash('success', 'Lead converted to customer!');
        return $this->redirectToRoute('lead_index');
    }
    
    public function addCustomer($leadId) {
                
            $em = $this->getDoctrine()->getManager();
            $lead = $em->getRepository(Lead::class)->find($leadId);
                       
        
            $customer = new Customer();        
            
            $currentTime = new \DateTime("now"); //date("Y-m-d H:i:s", time());            
            
            
            $customer->setFullName($lead->getFullName());
            $customer->setEmail($lead->getEmail());
            $customer->setLocation($lead->getLocation());
            $customer->setPhone($lead->getPhone());
            $customer->setStatus(1);
            $customer->setCreatedAt($currentTime);
            
            $em->persist($customer);
            $em->flush();
       
            $this->addCustomerAddress($lead, $customer);
        
    }
    
    public function addCustomerAddress($lead, $customer) {
 
            $em = $this->getDoctrine()->getManager();
            
            $address = new CustomerAddress();
            
            $address1 = json_decode($lead->getAddress());
            $addressArr = explode(',', $address1);
            
            
            $address->setUserId($customer);
            
            if(isset($addressArr[0]))
            $address->setHouseNo($addressArr[0]);

            if(isset($addressArr[1]))
            $address->setStreet($addressArr[1]);

            if(isset($addressArr[2]))
            $address->setCity($addressArr[2]);

            if(isset($addressArr[3]))
            $address->setLandmark($addressArr[3]);

            
            $em->persist($address);
            $em->flush();        
    }
}
