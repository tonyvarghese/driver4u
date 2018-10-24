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
        $trip = new Trip();
        
        if ($request->request->has('submit')) {
            
            $scheduledTime = new \DateTime($request->request->get('stime'));
            //var_dump($scheduledTime); die;

            $trip->setCustomerId($request->request->get('customer'));
            $trip->setDriverId($request->request->get('driver'));
            $trip->setVehicleId($request->request->get('vehicle'));
            $trip->setScheduledTime($scheduledTime);
            $trip->setStatus(1);
            $trip->setRate($request->request->get('rate'));
            $trip->setDiscount($request->request->get('discount'));
            $trip->setAmountCollected(0);
            $trip->setCreatedAt(new \DateTime("now"));
            $trip->setUpdatedAt(new \DateTime("now"));
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($trip);
            $em->flush();
        
            // Flash messages are used to notify the user about the result of the
            // actions. They are deleted automatically from the session as soon
            // as they are accessed.
            // See https://symfony.com/doc/current/book/controller.html#flash-messages
            $this->addFlash('success', 'Trip Added Successfully');

            return $this->redirectToRoute('trip_new');
        }
        

        $em = $this->getDoctrine()->getManager();
        $drivers = $em->getRepository(Driver::class)->findAll();
        $customers = $em->getRepository(Customer::class)->findAll();


        return $this->render('admin/pages/trip/new.html.twig', ['drivers' => $drivers, 'customers' => $customers]);
    }    
}