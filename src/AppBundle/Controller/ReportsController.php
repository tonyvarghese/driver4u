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
    public function topCustomers()
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

        return $this->render('admin/pages/report/top_customers.html.twig', ['data' => $data]);
    }    

  /**
     * Lists all Trip entities.
     *
     *
     * @Route("/admin/reports/top-drivers", name="top_drivers_index")
     * @Method("GET")
     */
    public function topDrivers()
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

        return $this->render('admin/pages/report/top_drivers.html.twig', ['data' => $data]);
    }   

    /**
     * Lists all Trip entities.
     *
     *
     * @Route("/admin/reports/feedback", name="feedback_drivers")
     * @Method("GET")
     */
    public function feedback()
    {
        $em = $this->getDoctrine()->getManager();
//         $qb = $em->createQueryBuilder();
//        $query = $qb->select('t as trip')
//                ->from('AppBundle:Trip','t')
//                ->orderby('t.driver')
//                ->getQuery();
//        var_dump($query->getDQL());die;
                
        //$result = $query->getResult();      
         
         $trips = $em->getRepository(Trip::class)->findAll();
        
        $data = [];
        foreach ($trips as $key => $value) 
            {
            $driverId = $value->getDriver()->getId();
            $driverName = $value->getDriver()->getFullName();
            $data[$driverId][] = ['name' => $driverName, 'feedback' => $value->getFeedback()];
            }
        
//        echo "<pre>";
//        var_dump($data); 
//        echo "</pre>";
//        die;
        
         return $this->render('admin/pages/report/feedback_driver.html.twig',['data' => $data]);
    }
 

  /**
     *
     *
     * @Route("/admin/reports/lead-conversion", name="lead_conversion_report")
     * @Method("GET")
     */
    public function leadConversion()
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

        return $this->render('admin/pages/report/lead_conversion.html.twig', ['data' => $data]);
    } 
    
     /**
     * Lists all Trip entities.
     *
     *
     * @Route("/admin/reports/cancellation", name="cancellation_reports")
     * @Method("GET")
     */
    public function cancellationReport()
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
//      
        return $this->render('admin/pages/report/cancellation_reports.html.twig',['data' => $data]);
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
            ->where('t.scheduledTime > :start')
            ->andWhere('t.scheduledTime < :end')
            ->andWhere('t.status = 3')
            ->groupBy('t.driver')
            ->setParameter('start', new \DateTime($startDate), \Doctrine\DBAL\Types\Type::DATETIME)
            ->setParameter('end', new \DateTime($endDate), \Doctrine\DBAL\Types\Type::DATETIME);
            $trips = $qb->getQuery()->getResult();           
          
            //var_dump(count($trips)); die;
        
        return $this->render('admin/pages/report/drivers_drives_taken.html.twig',['trips' => $trips, 'start' => $request->request->get('start'),'end' => $request->request->get('end')]);
    }
    
}