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
     * @Route("/admin/reports/top-customers", name="top_customers_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
       
         
        $trips = $em->getRepository(Trip::class)->findAll();
        
        
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

//        
//        $db = $em->createQueryBuilder('mytable');
//        $db
//            ->addSelect('COUNT(*) as count')
//            ->groupBy('mytable.email')
//            ->orderBy('mytable.id', 'DESC')
//            ->setFirstResult(0)
//            ->setMaxResults(30);
//        $result = $db->getQuery()->getResult();
//        
//$query = $em->createQuery(
//    'SELECT p
//    FROM AppBundle:Product p
//    WHERE p.price > :price
//    ORDER BY p.price ASC'
//)->setParameter('price', 19.99);
//
//$products = $query->getResult();
//
//$sql = $this->createQueryBuilder('s')
//        ->select('SUM(s.expenses) AS total')
//        ->groupBy('s.keyval')
//        ;
        

        //$repository = $this->getDoctrine()->getRepository(Trip::class);
        
        
        
$query = $em->createQuery(
    'SELECT sum(t.rate), IDENTITY(t.customer), (t.driver)
    FROM AppBundle:Trip t
    GROUP BY t.customer
    ORDER BY t.id ASC 
    '
);

$data = $query->getResult();

echo count($data); die;

        
$queryBuilder = $this->getDoctrine()->createQueryBuilder('t');


$queryBuilder
    ->select('SUM(rate) as total', 'customer')
    ->from('trips')
    ->groupBy('total')
;

$data = $queryBuilder->getResult();

echo count($data); die;

        
    //->select('SUM(t.rate) as ttotal', 't.customer')
        
//    ->select('SUM(t.rate) as ttotal, t.customer')
        //->select('count(a.adkey) as adKeyCount, a.adKey')
    //->where('p.price > :price')
    //->setParameter('price', '19.99')
//    ->orderBy('ttotal', 'ASC')
//    ->groupBy('t.customer')
//    ->getQuery();

$data = $query->getResult();



//$queryBuilder
//    ->select('DATE(last_login) as date', 'COUNT(id) AS users')
//    ->from('users')
//    ->groupBy('DATE(last_login)')
//    ->having('users > 10')
//;

echo count($data); die;

        return $this->render('admin/pages/report/top_customers.html.twig', ['trips' => $trips, 'status' => $this->statusCodes()]);
    }    
}
