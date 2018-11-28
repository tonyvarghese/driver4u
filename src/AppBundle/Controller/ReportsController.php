<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Trip;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReportsController extends Controller
{
        
   /**
     * Lists all Trip entities.
     *
     *
     * @Route("/admin/reports/top-customers", name="top_customers_index")
     * @Method("GET")
     */
    public function topCustomers(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
       
         //https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/query-builder.html
 
        $qb = $em->createQueryBuilder();
        $query = $qb->select('t as trip', 'SUM(t.amountCollected) as total')
           ->from('AppBundle:Trip', 't')
           ->groupby('t.customer')
           ->orderBy('total', 'DESC')
           ->setMaxResults(5)
           ->getQuery();

        $data = $query->getResult();     
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $data, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/);

        return $this->render('admin/pages/report/top_customers.html.twig', ['data' => $pagination]);
    }    
    
   /**
     * Lists all Trip entities.
     *
     *
     * @Route("/admin/reports/customers-revenue", name="customers_revenue_index")
     * @Method("GET")
     */
    public function customersRevenue(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
       
         //https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/query-builder.html
 
        $qb = $em->createQueryBuilder();
        $query = $qb->select('t as trip', 'SUM(t.amountCollected) as total')
           ->from('AppBundle:Trip', 't')
           ->groupby('t.customer')
           ->orderBy('total', 'DESC')
           ->getQuery();

        $data = $query->getResult();   
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $data, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/);

        return $this->render('admin/pages/report/customers_revenue.html.twig', ['data' => $pagination]);
    }     

  /**
     * Lists all Trip entities.
     *
     *
     * @Route("/admin/reports/top-drivers", name="top_drivers_index")
     * @Method("GET")
     */
    public function topDrivers(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
       
         //https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/query-builder.html

        $qb = $em->createQueryBuilder();
        $query = $qb->select('t as trip', 'SUM(t.amountCollected) as total')
           ->from('AppBundle:Trip', 't')
           ->groupby('t.driver')
           ->orderBy('total', 'DESC')
           ->setMaxResults(5)
           ->getQuery();

        $data = $query->getResult(); 
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $data, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/);

        return $this->render('admin/pages/report/top_drivers.html.twig', ['data' => $pagination]);
    }   

    
   /**
     * Lists all Trip entities.
     *
     *
     * @Route("/admin/reports/drivers-revenue", name="drivers_revenue_index")
     * @Method("GET")
     */
    public function driversRevenue(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
       
         //https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/query-builder.html
 
        $qb = $em->createQueryBuilder();
        $query = $qb->select('t as trip', 'SUM(t.amountCollected) as total')
           ->from('AppBundle:Trip', 't')
           ->groupby('t.driver')
           ->orderBy('total', 'DESC')
           ->getQuery();

        $data = $query->getResult();      
        
         $paginator  = $this->get('knp_paginator');
        
        $pagination = $paginator->paginate(
            $data, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/);

        return $this->render('admin/pages/report/drivers_revenue.html.twig', ['data' => $pagination]);
    }     
    
    /**
     * Lists all Trip entities.
     *
     *
     * @Route("/admin/reports/feedback", name="feedback_drivers")
     * @Method("GET")
     */
    public function feedback(Request $request)
    {
//        $em = $this->getDoctrine()->getManager();
//         $qb = $em->createQueryBuilder();
//        $query = $qb->select('t as trip')
//                ->from('AppBundle:Trip','t')
//                ->orderby('t.driver')
//                ->getQuery();
//        var_dump($query->getDQL());die;
                
        //$result = $query->getResult();      
         
//         $trips = $em->getRepository(Trip::class)->findAll();
             
        
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $expr = $qb->expr();

        $query = $qb
            ->select('t')
            ->from('AppBundle:Trip','t')
//            ->where($expr->neq('t.driver', null))
            ->where($expr->isNotNull('t.driver'))               
            ->getQuery();     
        $trips = $query->getResult();
        
        $data = [];
        foreach ($trips as $key => $value) 
            {
                if($value->getFeedback() == '')
                    continue;
                
                $driverId = $value->getDriver()->getId();
                $driverName = $value->getDriver()->getFullName();
                $data[$driverId][] = ['name' => $driverName, 'feedback' => $value->getFeedback()];
            }
        
//        echo "<pre>";
//        var_dump($data); 
//        echo "</pre>";
//        die;
             
            $paginator  = $this->get('knp_paginator');
             
            $pagination = $paginator->paginate(
            $data, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/);
        
         return $this->render('admin/pages/report/feedback_driver.html.twig',['data' => $pagination]);
    }
 

  /**
     *
     *
     * @Route("/admin/reports/lead-conversion", name="lead_conversion_report")
     * @Method({"GET", "POST"})
     */
    public function leadConversion(Request $request)
    {
        
        $startDate = strtotime($request->request->get('start-date'));
        $startDate = date("Y-m-d", $startDate);

        $endDate = strtotime($request->request->get('end-date'));
        $endDate = date("Y-m-d", $endDate);

        
        $em = $this->getDoctrine()->getManager();
       
         //https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/query-builder.html

        $qb = $em->createQueryBuilder();
        $query = $qb->select('l.status')
           ->from('AppBundle:Lead', 'l')
            ->where('l.createdAt >= :start')
            ->andWhere('l.createdAt <= :end')
            ->setParameter('start', new \DateTime($startDate), \Doctrine\DBAL\Types\Type::DATETIME)
            ->setParameter('end', new \DateTime($endDate), \Doctrine\DBAL\Types\Type::DATETIME)                
           ->getQuery();

        $data = $query->getResult();   
        
        $total = 0;
        $converted = 0;
        $conversionRate = 0;
        foreach ($data as $key => $value) {
            $status = $value['status'];
            
            if($status == 4)
                $converted ++;
            
            $total++;            
        }
        
        if($total>0)
        $conversionRate = round(($converted/$total) * 100);
        
        return $this->render('admin/pages/report/lead_conversion.html.twig', [
            'total' => $total, 
            'converted' => $converted, 
            'conversionRate' => $conversionRate,
            'startDate' => $request->request->get('start-date'),
            'endDate' => $request->request->get('end-date')
        ]);
    } 
    
     /**
     * Lists all Trip entities.
     *
     *
     * @Route("/admin/reports/cancellation", name="cancellation_reports")
     * @Method("GET")
     */
    public function cancellationReport(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
       
         //https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/query-builder.html

//        $qb = $em->createQueryBuilder();
//        $query = $qb->select('t as trip')
//           ->from('AppBundle:Trip', 't')
//           ->orderby('t.cancelledBy')
//           ->getQuery();
        //        $data = $query->getResult(); 
        $repository = $this->getDoctrine()->getRepository(Trip::class);

        $trips = $repository->findBy(
            array('status' => '4'));
        
        $data = [];
        foreach ($trips as $key => $value) 
            {
            $customerId = $value->getCustomer()->getId();
            $customerName = $value->getCustomer()->getFullName();
            $data[$customerId][] = ['name' => $customerName, 'cancelledBy' => $value->getCancelledBy(),'reason' => $value->getCancelReason()];
            }
//            echo "<pre>";
//            var_dump($data); 
//        echo "</pre>";
//        die;

          $paginator  = $this->get('knp_paginator');
        
        $pagination = $paginator->paginate(
            $data, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/);
        
//      
        return $this->render('admin/pages/report/cancellation_reports.html.twig',['data' => $pagination]);
    }
    
     /**
     * Lists all Trip entities.
     *
     *
     * @Route("/admin/reports/drivers_drives_taken", name="drivers_drives_taken")
     * @Method({"GET", "POST"})
     */
    public function driversdrivesTaken(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//       
//        $repository = $this->getDoctrine()->getRepository(Trip::class);
////        $trips = $repository->findBy(
////            array('status' => '4'));
//        $query = $em->createQuery(
//    'SELECT t
//    FROM AppBundle:Trip t
//    WHERE t.createdAt BETWEEN 01/01/2018 and 01/31/2018
//    ORDER BY t.driver ASC');
//
//           $trips = $query->getResult(); 
           
        
        $startDate = strtotime($request->request->get('start'));
        $startDate = date("Y-m-d", $startDate);

        $endDate = strtotime($request->request->get('end'));
        $endDate = date("Y-m-d", $endDate);

        
        // 21/11/2018
        // '2008-01-02'
        
            $qb = $em->createQueryBuilder();
            $qb->select('t as trip','COUNT(t) as total')
            ->from('AppBundle:Trip', 't')
            ->where('t.startedTime >= :start')
            ->andWhere('t.startedTime <= :end')
            ->andWhere('t.status = 3')
            ->andWhere('t.driver != \'\'')        
            ->groupBy('t.driver')
            ->setParameter('start', new \DateTime($startDate), \Doctrine\DBAL\Types\Type::DATETIME)
            ->setParameter('end', new \DateTime($endDate), \Doctrine\DBAL\Types\Type::DATETIME);
            $trips = $qb->getQuery()->getResult();           
          
            //var_dump(count($trips)); die;
            
            $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $trips, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/);
        
        return $this->render('admin/pages/report/drivers_drives_taken.html.twig',['trips' => $pagination, 'start' => $request->request->get('start'),'end' => $request->request->get('end')]);
    }
    
    
     /**
     * Lists all Trip entities.
     *
     *
     * @Route("/admin/reports/customer-service-request-frequency", name="customers_service_frequency")
     * @Method({"GET", "POST"})
     */
    public function customersServiceFrequency(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
           
        
        $startDate = strtotime($request->request->get('start'));
        $startDate = date("Y-m-d", $startDate);

        $endDate = strtotime($request->request->get('end'));
        $endDate = date("Y-m-d", $endDate);

        $qb = $em->createQueryBuilder();
        $qb->select('t as trip','COUNT(t) as total')
        ->from('AppBundle:Trip', 't')
        ->where('t.startedTime >= :start')
        ->andWhere('t.startedTime <= :end')
        ->andWhere('t.status = 3')
        ->groupBy('t.customer')
        ->setParameter('start', new \DateTime($startDate), \Doctrine\DBAL\Types\Type::DATETIME)
        ->setParameter('end', new \DateTime($endDate), \Doctrine\DBAL\Types\Type::DATETIME);
        $trips = $qb->getQuery()->getResult();           
        
         $paginator  = $this->get('knp_paginator');

        $pagination = $paginator->paginate(
            $trips, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/);
  
        
        return $this->render('admin/pages/report/customer_service_frequency.html.twig',['trips' => $pagination, 'start' => $request->request->get('start'),'end' => $request->request->get('end')]);
    }
    
}