<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class DashboardController extends Controller
{
     /**
     * @Route("/admin/dashboard", name="dashboard")
     * @Method("GET")
     */
    public function showLayout()
    {
        return $this->render('admin/pages/dashboard/dashboard.html.twig');
    } 
}
