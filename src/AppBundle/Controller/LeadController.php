<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Leads;
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

    /**
     * @Route("admin/leads", name="lead_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $leads = $em->getRepository(Leads::class)->findAll();

        $data = [];
        foreach ($leads as $key => $value)
        {
            $data[$key]['id'] = $value->getId();
            $data[$key]['fullName'] = $value->getFullName();
            $data[$key]['email'] = $value->getEmail();
            $data[$key]['phone'] = json_decode($value->getPhone());
            $data[$key]['address'] = json_decode($value->getAddress());
            $data[$key]['location'] = $value->getLocation();
            $data[$key]['feedback'] = $value->getFeedback();
            $data[$key]['status'] = $value->getStatus();
            $data[$key]['followupDate'] = $value->getFollowupDate();
        }

        //print_r($data); die;

        return $this->render('admin/pages/lead/index.html.twig',['leads' => $data]);
    }

    /**
     * @Route("admin/lead/new", name="lead_new")
     * @Method({"GET", "POST"})
     */
    public function addLeadAction(Request $request)
    {
       $lead = new Leads();
        if ($request->request->has('submit'))
        {
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
        $lead = new Leads();
        $followupDate = new \DateTime($request->request->get('followup'));

        if ($request->request->has('submit'))
        {

            $entityManager = $this->getDoctrine()->getManager();
            $lead = $entityManager->getRepository(Leads::class)->find($id);
            if (!$lead)
            {
                throw $this->createNotFoundException(
                    'No customer found for id '.$id
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

            $this->addFlash('success', 'Lead Updated Successfully');
            $entityManager->flush();
            return $this->redirectToRoute('lead_edit', ['id' => $id]);
        }
        $repository = $this->getDoctrine()->getRepository(Leads::class);
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

        $repository = $this->getDoctrine()->getRepository(Leads::class);
        $driverObj = $repository->find($id);
        $data['name'] = $driverObj->getFullName();
        $data['email'] = $driverObj->getEmail();
        $data['address'] = json_decode($driverObj->getAddress());
        $data['phone'] = json_decode($driverObj->getPhone());
        $data['location'] = $driverObj->getLocation();
        $data['status'] = $driverObj->getStatus();
        $data['feedback'] = $driverObj->getFeedback();
        $data['followupDate'] = $driverObj->getFollowupDate();
        $data['createdAt'] = $driverObj->getCreatedAt();


        return $this->render("admin/pages/lead/view.html.twig",['lead'=>$data]);
    }

}
