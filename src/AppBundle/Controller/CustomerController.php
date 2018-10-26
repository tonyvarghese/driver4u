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
use AppBundle\Entity\Address;


class CustomerController extends Controller
{
    public function customerType()
    {
        return [0=>"", 1 => "Monthly", 2=> "On Demand"];
    }

    public function jsonToString($json, $values){
        $data  = [];
        $jsonObj = json_decode($json);

        if ($jsonObj) {
            foreach ($jsonObj as $item){
                $data[] = $values[$item];
            }

            return implode(',', $data);
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
        
            $q = $em->createQuery("delete from AppBundle\Entity\Address a where a.userId = $userId");
            $numDeleted = $q->execute();

            $customer = $em->getRepository(Customer::class)->find($userId);
        
        
        $count = count($request->request->get('street'));
        
        for($i = 0; $i < $count; $i++){
            $house = $request->request->get('house-number')[$i];
            $street = $request->request->get('street')[$i];
            $city = $request->request->get('city')[$i];
            $landmark = $request->request->get('landmark')[$i];
            
            $address = new Address();
            
            $address->setUserType(1);
            $address->setUserId($customer);
            $address->setHouseNo($house);
            $address->setStreet($street);
            $address->setCity($city);
            $address->setLandmark($landmark);
            
            $em->persist($address);
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
            
            $customer->setFullName($request->request->get('fullname'));
            $customer->setEmail($request->request->get('email'));
            $customer->setLocation($request->request->get('location'));
            $customer->setPhone(json_encode($request->request->get('phone')));
            $customer->setStatus(1);
            $customer->setUsualTrip($request->request->get('usualTrip'));
            $customer->setCustomerType(json_encode($request->request->get('customertype')));
            $customer->setPreferredDriver($request->request->get('driver'));
            $customer->setCreatedAt($currentTime);
            
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();
        
            $this->addAddress($request, $customer->getId());
            
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
            
            $customer->setFullName($request->request->get('fullname'));
            $customer->setEmail($request->request->get('email'));
            $customer->setLocation($request->request->get('location'));
            $customer->setPhone(json_encode($request->request->get('phone')));
            $customer->setStatus(1);
            $customer->setUsualTrip($request->request->get('usualTrip'));
            $customer->setCustomerType(json_encode($request->request->get('customertype')));
            $customer->setPreferredDriver($request->request->get('driver'));
            
            $entityManager->flush();
                        
            $this->addAddress($request, $id);
        
            $this->addFlash('success', 'Customer updated successfully');

            return $this->redirectToRoute('customer_edit', ['id' => $id]);
        }
        
        $repository = $this->getDoctrine()->getRepository(Customer::class);
        $customerObj = $repository->find($id);
        $data['fullName'] = $customerObj->getFullName();
        $data['email'] = $customerObj->getEmail();
        $data['location'] = $customerObj->getLocation();
        $data['addresses'] = $customerObj->getAddresses();
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
     * Deletes a Customer entity.
     *
     * @Route("/admin/customer/delete/{id}", name="customer_delete")
     * @Method("GET")
     *
     */
    public function deleteAction(Request $request, Customer $customer)
    {

        $customer->getAddresses()->clear();
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($customer);
        $em->flush();
        
        

        $this->addFlash('success', 'Customer Deleted successfully');

        return $this->redirectToRoute('customer_index');
    }    
 
}
