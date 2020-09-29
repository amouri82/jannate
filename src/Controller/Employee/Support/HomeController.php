<?php

namespace App\Controller\Employee\Support;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HomeController extends AbstractController
{
    /**
     * @Route("/employee/support", name="employee.support.home")
     */
    public function index()
    {
        return $this->render('employee/support/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
