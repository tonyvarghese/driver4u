<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\User;
use AppBundle\Entity\Customer;
use AppBundle\Entity\Driver;
use AppBundle\Entity\CustomerAddress;
use AppBundle\Entity\CustomerVehicle;


class CustomerController extends Controller
{
    public function customerType()
    {
        return [0=>"", 1 => "Monthly", 2=> "On Demand"];
    }
    
//    public function vehileTypes() {
//        return [0 => "", 1 => "Manual", 2 => "Automatic", 3 => "Premium"];
//    }    

    public function jsonToString($json, $values){
        $data  = [];
        $jsonObj = json_decode($json);

        if ($jsonObj) {
            foreach ($jsonObj as $item){
                $data[] = $values[$item];
            }

            return implode(', ', $data);
        }

        return "";
    }


    /**
     * Lists all Customer entities.
     *
     *
     * @Route("/admin/customers", name="customer_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $customers = $em->getRepository(Customer::class)->findAll();
        
        $data = [];
        foreach ($customers as $key => $value) {
            $data[$key]['id'] = $value->getId();
            $data[$key]['fullName'] = $value->getFullName();
            $data[$key]['email'] = $value->getEmail();
            $data[$key]['phones'] = json_decode($value->getPhone());
            $data[$key]['location'] = $value->getLocation();
            $data[$key]['addresses'] = $value->getAddresses();
            $data[$key]['usualTrip'] = $value->getUsualTrip();
            $data[$key]['customertype'] = $this->jsonToString($value->getCustomerType(), $this->customerType());

        }
        
        $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $data, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('admin/pages/customer/index.html.twig', ['customers' => $pagination]);
    }
    
    public function addAddress($request, $userId) {

            $em = $this->getDoctrine()->getManager();
        
            $q = $em->createQuery("delete from AppBundle\Entity\CustomerAddress a where a.userId = $userId");
            $numDeleted = $q->execute();

            $customer = $em->getRepository(Customer::class)->find($userId);
        
        
        $count = count($request->request->get('street'));
        
        for($i = 0; $i < $count; $i++){
            $house = trim($request->request->get('house-number')[$i]);
            $street = trim($request->request->get('street')[$i]);
            $city = trim($request->request->get('city')[$i]);
            $landmark = trim($request->request->get('landmark')[$i]);
            
            if($house == '' && $street == '' && $city == '' && $landmark == '' )
                continue;
            
            
            $address = new CustomerAddress();
            
//            $address->setUserType(1);
            $address->setUserId($customer);
            $address->setHouseNo($house);
            $address->setStreet($street);
            $address->setCity($city);
            $address->setLandmark($landmark);
            
            $em->persist($address);
            $em->flush();            
        }
        
    }

    public function addVehicles($request, $userId) {

            $em = $this->getDoctrine()->getManager();
        
            $q = $em->createQuery("delete from AppBundle\Entity\CustomerVehicle a where a.customerId = $userId");
            $numDeleted = $q->execute();

            $customer = $em->getRepository(Customer::class)->find($userId);
        
        
        $count = count($request->request->get('model'));
        
        for($i = 0; $i < $count; $i++){
            $regNumber = trim($request->request->get('reg-number')[$i]);
            $model = trim($request->request->get('model')[$i]);
            $type = trim($request->request->get('type')[$i]);
            
            $vehicle = new CustomerVehicle();
            
            $vehicle->setCustomerId($customer);
            $vehicle->setVehicleModel($model);
            $vehicle->setRegNumber($regNumber);
            $vehicle->setVehicleType($type);
            $vehicle->setCreatedAt(new \DateTime("now"));
            $vehicle->setUpdatedAt(new \DateTime("now"));
            
            $em->persist($vehicle);
            $em->flush();            
        }
        
    }
    
        /**
     * Creates a new Customer entity.
     *
     * @Route("admin/customer/new", name="customer_new")
     * @Method({"GET", "POST"})
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function newAction(Request $request)
    {        
        $customer = new Customer();        

        if ($request->request->has('submit')) {
            
            $currentTime = new \DateTime("now"); //date("Y-m-d H:i:s", time());
            
            $em = $this->getDoctrine()->getManager();
            $driver = $em->getRepository(Driver::class)->find($request->request->get('driver'));
            
            $customer->setFullName($request->request->get('fullname'));
            $customer->setEmail($request->request->get('email'));
            $customer->setLocation($request->request->get('location'));
            $customer->setPhone(json_encode($request->request->get('phone')));
            $customer->setStatus(1);
            $customer->setUsualTrip($request->request->get('usualTrip'));
            $customer->setCustomerType(json_encode($request->request->get('customertype')));                        
            $customer->setCreatedAt($currentTime);
            
            if($driver)
                $customer->setPreferredDriver($driver);            
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();
        
            $this->addAddress($request, $customer->getId());
            $this->addVehicles($request, $customer->getId());
            
            // Flash messages are used to notify the user about the result of the
            // actions. They are deleted automatically from the session as soon
            // as they are accessed.
            // See https://symfony.com/doc/current/book/controller.html#flash-messages
            $this->addFlash('success', 'Customer created_successfully');

            return $this->redirectToRoute('customer_new');
        }
        

//        $em = $this->getDoctrine()->getManager();
//        $qb = $em->createQueryBuilder();

        // this returns an array 
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

        $em = $this->getDoctrine()->getManager();
        $drivers = $em->getRepository(Driver::class)->findAll();


        return $this->render('admin/pages/customer/new.html.twig', ['drivers' => $drivers]);
    }
    
    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/admin/customer/edit/{id}", requirements={"id": "\d+"}, name="customer_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        
        if ($request->request->has('submit')) {
            
            $entityManager = $this->getDoctrine()->getManager();
            $customer = $entityManager->getRepository(Customer::class)->find($id);
            if (!$customer) {
                throw $this->createNotFoundException(
                    'No customer found for id '.$id
                );
            }
            
            $driver = $entityManager->getRepository(Driver::class)->find($request->request->get('driver'));
            
            $customer->setFullName($request->request->get('fullname'));
            $customer->setEmail($request->request->get('email'));
            $customer->setLocation($request->request->get('location'));
            $customer->setPhone(json_encode($request->request->get('phone')));
            $customer->setStatus(1);
            $customer->setUsualTrip($request->request->get('usualTrip'));
            $customer->setCustomerType(json_encode($request->request->get('customertype')));
            
            if($driver)
            $customer->setPreferredDriver($driver);
            
            $entityManager->flush();
                        
            $this->addAddress($request, $id);
            $this->addVehicles($request, $id);
        
            $this->addFlash('success', 'Customer updated successfully');

            return $this->redirectToRoute('customer_edit', ['id' => $id]);
        }
        
        $repository = $this->getDoctrine()->getRepository(Customer::class);
        $customerObj = $repository->find($id);
        $data['fullName'] = $customerObj->getFullName();
        $data['email'] = $customerObj->getEmail();
        $data['location'] = $customerObj->getLocation();
        $data['addresses'] = $customerObj->getAddresses();
        $data['vehicles'] = $this->vehiclesParse($customerObj->getVehicles());
        $data['phone'] = json_decode($customerObj->getPhone());
        $data['usualTrip'] = $customerObj->getUsualTrip();
        $data['customertype'] = json_decode($customerObj->getCustomerType());
        $data['preferredDriver'] = $customerObj->getPreferredDriver();
        
        
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

        $em = $this->getDoctrine()->getManager();
        $drivers = $em->getRepository(Driver::class)->findAll();

        return $this->render('admin/pages/customer/edit.html.twig', ['drivers' => $drivers, 'data' => $data]);
        
    }   
    
    /**
     * @Route("admin/customer/view/{id}", name="customer_view")
     * @Method({"GET", "POST"})
     */
    public function viewAction($id) {

        $repository = $this->getDoctrine()->getRepository(Customer::class);
        $customerObj = $repository->find($id);
             
        $data['name'] = $customerObj->getFullName();
        $data['email'] = $customerObj->getEmail();
        $data['location'] = $customerObj->getLocation();
        $data['addresses'] = $customerObj->getAddresses();
        $data['vehicles'] = $this->vehiclesParse($customerObj->getVehicles());
        $data['phone'] = json_decode($customerObj->getPhone());
        $data['usualTrip'] = $customerObj->getUsualTrip();
        $data['customerType'] = $this->jsonToString($customerObj->getCustomerType(), $this->customerType());
        $data['preferredDriver'] = $customerObj->getPreferredDriver() ? $customerObj->getPreferredDriver()->getFullName() : "";
        

        return $this->render("admin/pages/customer/view.html.twig", ['customer' => $data]);
    }
    
    public function vehiclesParse($vehicles){
        $data = [];
        
        foreach ($vehicles as $key => $value) {
            $data[$key]['regNumber'] = $value->getRegNumber();
            $data[$key]['vehicleModel'] = $value->getVehicleModel();
            $data[$key]['vehicleTypes'] = json_decode($value->getVehicleType());
            $data[$key]['vehicleTypesJson'] = ($value->getVehicleType() != '') ? $value->getVehicleType() : '[]';            
        }
        return $data;
    }

    

    /**
     * Deletes a Customer entity.
     *
     * @Route("/admin/customer/delete/{id}", name="customer_delete")
     * @Method("GET")
     *
     */
    public function deleteAction(Request $request, Customer $customer)
    {

        
        $customer->getAddresses()->clear();
        $customer->getVehicles()->clear();

        $em = $this->getDoctrine()->getManager();
        $em->remove($customer);
        $em->flush();
        
        

        $this->addFlash('success', 'Customer Deleted successfully');

        return $this->redirectToRoute('customer_index');
    }    
 
}
