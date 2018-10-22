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


class CustomerController extends Controller
{
    
    /**
     * Lists all Customer entities.
     *
     *
     * @Route("/admin/customers", name="customer_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $customers = $em->getRepository(Customer::class)->findAll();
        
        $data = [];
        foreach ($customers as $key => $value) {
            $data[$key]['id'] = $value->getId();
            $data[$key]['fullName'] = $value->getFullName();
            $data[$key]['email'] = $value->getEmail();
            $data[$key]['phone'] = json_decode($value->getPhone());
            $data[$key]['address'] = json_decode($value->getAddress());
            $data[$key]['usualTrip'] = $value->getUsualTrip();
        }
        
        //print_r($data); die;

        return $this->render('admin/pages/customer/index.html.twig', ['customers' => $data]);
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
        
//        $form = $this->createForm(PostType::class, $post);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $post->setSlug($slugger->slugify($post->getTitle()));
//            $this->getDoctrine()->getManager()->flush();
//
//            $this->addFlash('success', 'post.updated_successfully');
//
//            return $this->redirectToRoute('admin_post_edit', ['id' => $post->getId()]);
//        }
//
//        return $this->render('admin/blog/edit.html.twig', [
//            'post' => $post,
//            'form' => $form->createView(),
//        ]);
        
        $customer = new Customer();
        

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
        
        $repository = $this->getDoctrine()->getRepository(Customer::class);
        $customerObj = $repository->find($id);
        $data['fullName'] = $customerObj->getFullName();
        $data['email'] = $customerObj->getEmail();
        $data['address'] = json_decode($customerObj->getAddress());
        $data['phone'] = json_decode($customerObj->getPhone());
        $data['usualTrip'] = $customerObj->getUsualTrip();
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
 
}
