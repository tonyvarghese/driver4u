<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Trip;
use AppBundle\Entity\Customer;
use AppBundle\Entity\Driver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;



class TripController extends Controller
{

        /**
     * Creates a new Trip entity.
     *
     * @Route("admin/trip/new", name="trip_new")
     * @Method({"GET", "POST"})
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function newAction(Request $request)
    {        
        $customer = new Trip();
        

        if ($request->request->has('submit')) {

            $customer->setFullName($request->request->get('fullname'));
            $customer->setEmail($request->request->get('email'));
            $customer->setAddress(json_encode($request->request->get('address')));
            $customer->setPhone(json_encode($request->request->get('phone')));
            $customer->setStatus(1);
            $customer->setUsualTrip($request->request->get('usualTrip'));
            $customer->setPreferredDriver($request->request->get('driver'));
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();
        
            // Flash messages are used to notify the user about the result of the
            // actions. They are deleted automatically from the session as soon
            // as they are accessed.
            // See https://symfony.com/doc/current/book/controller.html#flash-messages
            $this->addFlash('success', 'Customer created_successfully');

            return $this->redirectToRoute('customer_new');
        }
        

        $em = $this->getDoctrine()->getManager();
        $drivers = $em->getRepository(Driver::class)->findAll();
        $customers = $em->getRepository(Customer::class)->findAll();


        return $this->render('admin/pages/trip/new.html.twig', ['drivers' => $drivers, 'customers' => $customers]);
    }    
}
