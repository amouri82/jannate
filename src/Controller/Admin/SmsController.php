<?php

namespace App\Controller\Admin;

use App\Entity\Sms;
use App\Form\SmsType;
use App\Repository\SmsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SmsController extends AbstractController
{

    /**
     * @var SmsRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        SmsRepository $repository,
        EntityManagerInterface $em
    ) {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/sms", name="admin.sms.index")
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $count = $this->repository->count([]);

        $sms_services = $paginator->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );
        // parameters to template
        return $this->render('admin/sms/index.html.twig', [
            'sms_services' => $sms_services,
            'count' => $count
        ]);
    }

    /**
     * @Route("/admin/sms/new", name="admin.sms.new")
     * @Route("/admin/sms/{id}", name="admin.sms.edit")
     * @param Sms  $sms
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Sms $sms = null, Request $request)
    {
        $new = false;
        if(!$sms) {
            $sms = new Sms();
            $new = true;
        }

        $form = $this->createForm(SmsType::class, $sms);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($sms);
            $this->em->flush();
            if($new) {
                $this->addFlash('success' , "Sms Service successfully created");
            } else {
                $this->addFlash('success' , "Sms Service successfully updated");
            }
            return $this->redirectToRoute('admin.sms.index');
        }
        return $this->render('admin/sms/create.html.twig', [
            'form' => $form->createView(),
            'new' => $new
        ]);
    }

    /**
     * @Route("/admin/sms/delete/{id}", name="admin.sms.delete", methods="DELETE")
     * @param Sms  $sms
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Sms $sms, Request $request){
        $submittedToken = $request->request->get('token');
        if($this->isCsrfTokenValid('delete', $submittedToken)){
            $this->em->remove($sms);
            $this->em->flush();
            $this->addFlash('success' , "Record Successfully deleted");
        }
        return $this->redirectToRoute('admin.sms.index');
    }

}
