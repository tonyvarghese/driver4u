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

}
