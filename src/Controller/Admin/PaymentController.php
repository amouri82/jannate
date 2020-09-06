<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{

    /**
     * @Route("/admin/rules", name="admin.payment.rules")
     * @param Request            $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function rules(Request $request)
    {
        // parameters to template
        return $this->render('admin/payment/rules.html.twig');
    }
}
