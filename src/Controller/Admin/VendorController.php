<?php

namespace App\Controller\Admin;

use App\Entity\Vendor;
use App\Form\VendorType;
use App\Repository\VendorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    public function __construct(
        VendorRepository $repository,
        EntityManagerInterface $em
    ) {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/vendors", name="admin.vendors.index")
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $count = $this->repository->count([]);
        $vendors = $paginator->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );

        // parameters to template
        return $this->render('admin/vendor/index.html.twig', [
            'vendors' => $vendors,
            'count' => $count
        ]);
    }

    /**
     * @Route("/admin/vendor/new", name="admin.vendor.new")
     * @Route("/admin/vendor/{id}", name="admin.vendor.edit")
     * @param Vendor  $vendor
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Vendor $vendor = null, Request $request)
    {
        $new = false;
        if(!$vendor) {
            $vendor = new Vendor();
            $new = true;
        }

        $form = $this->createForm(VendorType::class, $vendor);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($vendor);
            $this->em->flush();
            if($new) {
                $this->addFlash('success' , "Vendor successfully created");
            } else {
                $this->addFlash('success' , "Vendor successfully updated");
            }
            return $this->redirectToRoute('admin.vendors.index');
        }
        return $this->render('admin/vendor/create.html.twig', [
            'form' => $form->createView(),
            'new' => $new
        ]);
    }

    /**
     * @Route("/admin/vendor/delete/{id}", name="admin.vendor.delete", methods="DELETE")
     * @param Vendor  $vendor
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Vendor $vendor, Request $request){
        $submittedToken = $request->request->get('token');
        if($this->isCsrfTokenValid('delete', $submittedToken)){
            $this->em->remove($vendor);
            $this->em->flush();
            $this->addFlash('success' , "Record Successfully deleted");
        }
        return $this->redirectToRoute('admin.vendors.index');
    }

}
