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
        $query = $qb->select('t as trip', 'SUM(t.rate) as total')
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
        $query = $qb->select('t as trip', 'SUM(t.rate) as total')
           ->from('AppBundle:Trip', 't')
           ->groupby('t.driver')
           ->orderBy('total', 'DESC')
           ->getQuery();

        $data = $query->getResult();        

        return $this->render('admin/pages/report/top_drivers.html.twig', ['data' => $data]);
    }       
}