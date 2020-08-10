<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class EmployeeController extends AbstractController
{
    /**
     * @Route("/employee", name="employee")
     * @IsGranted("ROLE_Employee")
     */
    public function index()
    {
        return $this->render('employee/home/index.html.twig', [
            'controller_name' => 'EmployeeController',
        ]);
    }
}
