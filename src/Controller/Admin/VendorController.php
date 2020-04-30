<?php

namespace App\Controller\Admin;

use App\Repository\VendorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VendorController extends AbstractController
{

    /**
     * @var VendorRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(VendorRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/vendor", name="admin.vendor.index")
     */
    public function index()
    {
        $vendors = $this->repository->findAll();

        return $this->render('admin/vendor/index.html.twig', [
            'vendors' => $vendors
        ]);
    }
}
