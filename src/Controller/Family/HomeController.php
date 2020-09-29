<?php

namespace App\Controller\Family;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HomeController extends AbstractController
{
    /**
     * @Route("/family", name="family.home.index")
     * @IsGranted("ROLE_USER")
     */
    public function index()
    {
        return $this->render('family/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
