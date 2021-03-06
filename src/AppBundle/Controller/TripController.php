<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Trip;
use AppBundle\Entity\Customer;
use AppBundle\Entity\CustomerVehicle;
use AppBundle\Entity\Driver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;


class TripController extends Controller
{
    
   
    
    public function statusCodes(){
        return [
            1 => 'Scheduled',
            2 => 'In Progress',
            3 => 'Completed',
            4 => 'Cancelled'
        ];
    }

    /**
     * Lists all Trip entities.
     *
     *
     * @Route("/admin/trips", name="trip_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $qb = $em->createQueryBuilder();
        
        if($request->request->has('start') && $request->request->get('start') != ''){
            $startDate = strtotime($request->request->get('start'));
            $startDate = date("Y-m-d h:i a", $startDate);

            $endDate = strtotime($request->request->get('end'));
            $endDate = date("Y-m-d h:i a", $endDate);

            $query = $qb->select('t as trip')
                    ->from('AppBundle:Trip', 't')
                    ->where('t.scheduledTime >= :start')
                    ->andWhere('t.scheduledTime <= :end')
                    ->setParameter('start', new \DateTime($startDate), \Doctrine\DBAL\Types\Type::DATETIME)
                    ->setParameter('end', new \DateTime($endDate), \Doctrine\DBAL\Types\Type::DATETIME);
        }
        else{
            $query = $qb->select('t as trip')
                    ->from('AppBundle:Trip', 't');
        }

        $trips = $qb->getQuery()->getResult();

//        $trips = $em->getRepository(Trip::class)->findAll();
        
        
        
//        $customer = $em->getRepository(Customer::class)->find($value->getCustomer());
//        if (!$customer) {
//            throw $this->createNotFoundException(
//                'No customer found for id '.$id
//            );
//        }        
        
//        $data = [];
//        foreach ($trips as $key => $value) {
//            $data[$key]['id'] = $value->getId();
//            $data[$key]['customer'] = $value->getCustomer()->email;
//            $data[$key]['vehicle'] = $value->getVehicleId();
//            $data[$key]['driver'] = $value->getDriver();
//            $data[$key]['stime'] = $value->getScheduledTime();
//            $data[$key]['rate'] = $value->getRate();
//            $data[$key]['discount'] = $value->getDiscount();
//            $data[$key]['status'] = $value->getStatus();
//        }
//        
//       print_r($data); die;

//        $paginator  = $this->get('knp_paginator');
//
//        $pagination = $paginator->paginate(
//            $trips, /* query NOT result */
//            $request->query->getInt('page', 1)/*page number*/,
//            10/*limit per page*/
//        );
        
        return $this->render('admin/pages/trip/index.html.twig', ['trips' => $trips,  'start' => $request->request->get('start'), 'end' => $request->request->get('end'), 'status' => $this->statusCodes()]);

    }
    

    /**
     * Lists all Trip entities.
     *
     *
     * @Route("/admin/cancelled/trips", name="cancelled_trips")
     * @Method("GET")
     */
    public function cancelledTripsAction()
    {

        $repository = $this->getDoctrine()->getRepository(Trip::class);

        $trips = $repository->findBy(
            array('status' => '4')
               
                
        );        
        
        return $this->render('admin/pages/trip/cancelled_trips.html.twig', ['trips' => $trips, 'status' => $this->statusCodes()]);
    }
    
        /**
     * Creates a new Trip entity.
     *
     * @Route("admin/trip/new", name="trip_new")
     * @Route("home", name="home")
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
            
            $em = $this->getDoctrine()->getManager();
            $customer = $em->getRepository(Customer::class)->find($request->request->get('customer'));
            $driver = $em->getRepository(Driver::class)->find($request->request->get('driver'));
            
            if($request->request->has('vehicle')){
                //$vehicle = $em->getRepository(CustomerVehicle::class)->find($request->request->get('vehicle'));
                $vehicle = $request->request->get('vehicle');
                if($vehicle != '')
                    $trip->setVehicle($vehicle);
            }
            

            $trip->setCustomer($customer);
            
            if($driver)
                $trip->setDriver($driver);            
            
            $trip->setScheduledTime($scheduledTime);
            $trip->setStatus(1);
            if($request->request->get('rate') != '')
                $trip->setRate($request->request->get('rate'));
            
            $trip->setLocation($request->request->get('location'));
            
            if($request->request->get('discount') != '')
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
      /**
     * Creates a new Trip entity.
     *
     * @Route("home", name="home")
     * @Method({"GET", "POST"})
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function homeAction(Request $request)
    {        
        $trip = new Trip();
        
        if ($request->request->has('submit')) {
            
            $scheduledTime = new \DateTime($request->request->get('stime'));            
            
            $em = $this->getDoctrine()->getManager();
            $customer = $em->getRepository(Customer::class)->find($request->request->get('customer'));
            $driver = $em->getRepository(Driver::class)->find($request->request->get('driver'));
            
            if($request->request->has('vehicle')){
                //$vehicle = $em->getRepository(CustomerVehicle::class)->find($request->request->get('vehicle'));
                $vehicle = $request->request->get('vehicle');
                if($vehicle != '')
                    $trip->setVehicle($vehicle);
            }
            

            $trip->setCustomer($customer);
            
            if($driver)
                $trip->setDriver($driver);            
            
            $trip->setScheduledTime($scheduledTime);
            $trip->setStatus(1);
            if($request->request->get('rate') != '')
                $trip->setRate($request->request->get('rate'));
            
            $trip->setLocation($request->request->get('location'));
            
            if($request->request->get('discount') != '')
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

            return $this->redirectToRoute('home');
        }
        

        $em = $this->getDoctrine()->getManager();
        $drivers = $em->getRepository(Driver::class)->findAll();
        $customers = $em->getRepository(Customer::class)->findAll();


        return $this->render('admin/pages/trip/home.html.twig', ['drivers' => $drivers, 'customers' => $customers]);
        
        
    }
    

 /**
     * Displays a form to close an existing Trip entity.
     *
     * @Route("/admin/trip/cancel/{id}", requirements={"id": "\d+"}, name="trip_cancel")
     * @Method({"GET", "POST"})
     */
    public function cancelAction(Request $request, $id)
    {
        
        if ($request->request->has('submit')) {
            
            $em = $this->getDoctrine()->getManager();
            $trip = $em->getRepository(Trip::class)->find($id);
            if (!$trip) {
                throw $this->createNotFoundException(
                    'No record found for id '.$id
                );
            }
            
            $trip->setCancelledBy($request->request->get('cancel-by'));
            $trip->setCancelReason($request->request->get('reason'));
            $trip->setStatus(4);
            $trip->setUpdatedAt(new \DateTime("now"));
            
            $em->flush();
        
            $this->addFlash('success', 'Trip cancelled!');

            return $this->redirectToRoute('trip_cancel', ['id' => $id]);
        }

        
        $repository = $this->getDoctrine()->getRepository(Trip::class);
        $trip = $repository->find($id);        
                
        $em = $this->getDoctrine()->getManager();


        return $this->render('admin/pages/trip/cancel.html.twig', ['trip' => $trip, 'status' => $this->statusCodes()]);
        
    }       

 /**
     * Displays a form to close an existing Trip entity.
     *
     * @Route("/admin/trip/close/{id}", requirements={"id": "\d+"}, name="trip_close")
     * @Method({"GET", "POST"})
     */
    public function closeAction(Request $request, $id)
    {
        
        if ($request->request->has('submit')) {
            
            $em = $this->getDoctrine()->getManager();
            $trip = $em->getRepository(Trip::class)->find($id);
            if (!$trip) {
                throw $this->createNotFoundException(
                    'No record found for id '.$id
                );
            }
            
            $startTime = new \DateTime($request->request->get('stime'));
            $endTime = new \DateTime($request->request->get('etime'));
            
            $trip->setStartedTime($startTime);
            $trip->setEndedTime($endTime);
            $trip->setAmountCollected($request->request->get('amount'));
            $trip->setFeedback($request->request->get('feedback'));
            $trip->setStatus(3);
            $trip->setUpdatedAt(new \DateTime("now"));
            
            $em->flush();
        
            $this->addFlash('success', 'Trip closed successfully');

            return $this->redirectToRoute('trip_close', ['id' => $id]);
        }
        
        $repository = $this->getDoctrine()->getRepository(Trip::class);
        $trip = $repository->find($id);        
                
        $em = $this->getDoctrine()->getManager();

        return $this->render('admin/pages/trip/close.html.twig', ['trip' => $trip, 'status' => $this->statusCodes()]);
        
    }   
    
 /**
     * Displays a form to edit an existing Trip entity.
     *
     * @Route("/admin/trip/edit/{id}", requirements={"id": "\d+"}, name="trip_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        
        if ($request->request->has('submit')) {
            
            $em = $this->getDoctrine()->getManager();
            $trip = $em->getRepository(Trip::class)->find($id);
            if (!$trip) {
                throw $this->createNotFoundException(
                    'No record found for id '.$id
                );
            }
            
            
            $customer = $em->getRepository(Customer::class)->find($request->request->get('customer'));
            $driver = $em->getRepository(Driver::class)->find($request->request->get('driver'));
            $scheduledTime = new \DateTime($request->request->get('stime'));
            
            
            if($request->request->has('vehicle')){
                //$vehicle = $em->getRepository(CustomerVehicle::class)->find($request->request->get('vehicle'));
                $vehicle = $request->request->get('vehicle');
                if($vehicle != '')
                    $trip->setVehicle($vehicle);
            }  
            
            
            
            
            $trip->setCustomer($customer);
            
            if($driver)
                $trip->setDriver($driver);
            
            $trip->setScheduledTime($scheduledTime);
            $trip->setStatus($request->request->get('status'));
            $trip->setRate($request->request->get('rate'));
            $trip->setLocation($request->request->get('location'));
            $trip->setDiscount($request->request->get('discount'));
//            $trip->setAmountCollected(0);
//            $trip->setCreatedAt(new \DateTime("now"));
//            $trip->setUpdatedAt(new \DateTime("now"));

            
            $em->flush();
        
            $this->addFlash('success', 'Trip updated successfully');

            return $this->redirectToRoute('trip_edit', ['id' => $id]);
        }
        
//        $repository = $this->getDoctrine()->getRepository(Trip::class);
//        $tripObj = $repository->find($id);
//        $data['customer'] = $tripObj->getCustomer();
//        $data['driver'] = $tripObj->getDriver();
//        $data['scheduledTime'] = json_decode($tripObj->getAddress());
//        $data['phone'] = json_decode($tripObj->getPhone());
//        $data['usualTrip'] = $tripObj->getUsualTrip();
//        $data['preferredDriver'] = $tripObj->getPreferredDriver();
        
        
//        $em = $this->getDoctrine()->getManager();
//        $qb = $em->createQueryBuilder();
//
//        // this returns an array
//        $drivers = $qb->select(array('u.id', 'u.fullName'))
//            ->from('AppBundle:DriverDetails', 'd')
//            ->join('AppBundle:User', 'u')
//            ->where('d.uid = u.id')
//            //->andWhere('e.user = :userName')
////            ->setParameter('userName', 'scott')
//            ->andWhere('u.roles like :roles')
//            ->setParameter('roles',  '%ROLE_DRIVER%')
//            ->orderBy('u.id', 'ASC')
//            ->getQuery()
//            ->getResult();

        
        $repository = $this->getDoctrine()->getRepository(Trip::class);
        $trip = $repository->find($id);        
                
        $em = $this->getDoctrine()->getManager();
        $drivers = $em->getRepository(Driver::class)->findAll();
        $customers = $em->getRepository(Customer::class)->findAll();
        
        $vehicles = $em->getRepository(CustomerVehicle::class)->findBy(array('customerId' => $trip->getCustomer()));           
        
        
        $vehicleId = $trip->getVehicle();
        
        if($vehicleId != NULL)  {
            $vehicle  = $this->getDoctrine()->getRepository(CustomerVehicle::class)->find($vehicleId);  
            if($vehicle) {
            $vehicletypes = json_decode($vehicle->getVehicleType());
            }
             else{
                 $vehicletypes = [];
        }
             }
            
        else{
            $vehicle  = [];
            $vehicletypes = [];
        }

        return $this->render('admin/pages/trip/edit.html.twig', ['customers' => $customers, 'drivers' => $drivers, 'trip' => $trip, 'vehicles' => $vehicles, 'status' => $this->statusCodes(),'vehicletypes' => $vehicletypes]);
        
    }   

    
 /**
     * Deletes a Trip entity.
     *
     * @Route("/admin/trip/delete/{id}", name="trip_delete")
     * @Method("GET")
     *
     */
    public function deleteAction(Request $request, Trip $trip)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($trip);
        $em->flush();

        $this->addFlash('success', 'Trip Deleted Successfully!');

        return $this->redirectToRoute('trip_index');
    }   

 

    /**
     * @Route("admin/trip/view/{id}", name="trip_view")
     * @Method({"GET", "POST"})
     */
    public function viewAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(Trip::class);
        $trip = $repository->find($id);
//        $data['name'] = $driverObj->getFullName();
//        $data['email'] = $driverObj->getEmail();
//        $data['location'] = $driverObj->getLocation();
//        $data['address'] = json_decode($driverObj->getAddress());
//        $data['phone'] = json_decode($driverObj->getPhone());
//        $data['age'] = $driverObj->getAge();
//        $data['drivertype'] =$this->jsonToString($driverObj->getDriverType(), $this->driverType()) ;
//        $data['expertise'] =($this->jsonToString($driverObj->getExpertise(), $this->expertise()));
//        $data['pcc'] = $this->pcc()[$driverObj->getPccSubmitted()];
//        $data['document'] =($this->jsonToString($driverObj->getDocument(), $this->document()));
//        $data['docnumber'] = $driverObj->getDocNumber();
//        $data['driverassignment'] = ($this->jsonToString($driverObj->getDriverAssignment(), $this->driverAssignment()));
//        $data['note'] = $driverObj->getNote();
//        $data['status'] = $driverObj->getStatus();
        
        $vehicleId = $trip->getVehicle();
        
        if($vehicleId != NULL)  {
            $vehicle  = $this->getDoctrine()->getRepository(CustomerVehicle::class)->find($vehicleId);  
            if($vehicle) {
            $vehicletypes = json_decode($vehicle->getVehicleType());
            }
             else{
                 $vehicletypes = [];
        }
             }
            
        else{
            $vehicle  = [];
            $vehicletypes = [];
        }

        return $this->render("admin/pages/trip/view.html.twig",['trip'=>$trip, 'status' => $this->statusCodes(), 'vehicle' => $vehicle, 'vehicletypes'=> $vehicletypes]);
    }        

    /**
     * @Route("admin/trip/customer/vehicles", name="get_vehicles")
     * @Method({"GET", "POST"})
     */    
    public function getVehicles(Request $request) {
        
        $id = $request->request->get('id');
                
        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository(Customer::class)->find($id);
        $vehiclesObj = $customer->getVehicles();
        //echo count($vehicles); die;
        
        $vehicles = [];
        foreach ($vehiclesObj as $key => $value) {
            
            $vehicleTypesArr = json_decode($value->getVehicleType());
            
            $vehicleTypes = implode(', ', $vehicleTypesArr);
            
            $vehicleData = [];
                    
            if($value->getVehicleModel() != '')
                $vehicleData[] = $value->getVehicleModel();
            
            if($vehicleTypes != '')
                $vehicleData[] = $vehicleTypes;
            
            
            $vehicles[$key] = [$value->getId(), implode(' - ', $vehicleData)];
        }
        
        return new JsonResponse($vehicles);
    }
}
 