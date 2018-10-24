<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Lead;
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
        return [0 => "", 1 => "Interested", 2 => "Not Interested", 3 => "Cancelled"];
    }

    /**
     * @Route("admin/leads", name="lead_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $leads = $em->getRepository(Lead::class)->findAll();

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

        //print_r($data); die;

        return $this->render('admin/pages/lead/index.html.twig', ['leads' => $data]);
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
            $lead->setPhone(json_encode($request->request->get('phone')));
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
            $lead->setPhone(json_encode($request->request->get('phone')));
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
        $this->addFlash('success', 'Post Deleted Successfully');
        return $this->redirectToRoute('lead_index');
    }
}
