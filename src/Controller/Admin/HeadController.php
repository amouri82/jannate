<?php

namespace App\Controller\Admin;

use App\Entity\Head;
use App\Form\HeadType;
use App\Repository\HeadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HeadController extends AbstractController
{

    /**
     * @var HeadRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        HeadRepository $repository,
        EntityManagerInterface $em
    ) {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/heads", name="admin.heads.index")
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $count = $this->repository->count([]);
        $heads = $paginator->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );
        // parameters to template
        return $this->render('admin/head/index.html.twig', [
            'heads' => $heads,
            'count' => $count
        ]);
    }

    /**
     * @Route("/admin/head/new", name="admin.head.new")
     * @Route("/admin/head/{id}", name="admin.head.edit")
     * @param Head  $head
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Head $head = null, Request $request)
    {
        $new = false;
        if(!$head) {
            $head = new Head();
            $new = true;
        }

        $form = $this->createForm(HeadType::class, $head);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($head);
            $this->em->flush();
            if($new) {
                $this->addFlash('success' , "Head successfully created");
            } else {
                $this->addFlash('success' , "Head successfully updated");
            }
            return $this->redirectToRoute('admin.heads.index');
        }
        return $this->render('admin/head/create.html.twig', [
            'form' => $form->createView(),
            'new' => $new
        ]);
    }

    /**
     * @Route("/admin/head/delete/{id}", name="admin.head.delete", methods="DELETE")
     * @param Head  $head
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Head $head, Request $request){
        $submittedToken = $request->request->get('token');
        if($this->isCsrfTokenValid('delete', $submittedToken)){
            $this->em->remove($head);
            $this->em->flush();
            $this->addFlash('success' , "Record Successfully deleted");
        }
        return $this->redirectToRoute('admin.heads.index');
    }

}
