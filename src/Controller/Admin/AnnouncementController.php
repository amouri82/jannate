<?php

namespace App\Controller\Admin;

use App\Entity\Announcement;
use App\Form\AnnouncementType;
use App\Repository\AnnouncementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AnnouncementController extends AbstractController
{

    /**
     * @var AnnouncementRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        AnnouncementRepository $repository,
        EntityManagerInterface $em
    ) {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/announcements", name="admin.announcements.index")
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $count = $this->repository->count([]);
        $announcements = $paginator->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );
        // parameters to template
        return $this->render('admin/announcement/index.html.twig', [
            'announcements' => $announcements,
            'count' => $count
        ]);
    }

    /**
     * @Route("/admin/announcement/new", name="admin.announcement.new")
     * @Route("/admin/announcement/{id}", name="admin.announcement.edit")
     * @param Announcement  $announcement
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Announcement $announcement = null, Request $request)
    {
        $new = false;
        if(!$announcement) {
            $announcement = new Announcement();
            $new = true;
        }

        $form = $this->createForm(AnnouncementType::class, $announcement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($announcement);
            $this->em->flush();
            if($new) {
                $this->addFlash('success' , "Announcement successfully created");
            } else {
                $this->addFlash('success' , "Announcement successfully updated");
            }
            return $this->redirectToRoute('admin.announcements.index');
        }
        return $this->render('admin/announcement/create.html.twig', [
            'form' => $form->createView(),
            'new' => $new
        ]);
    }

    /**
     * @Route("/admin/announcement/delete/{id}", name="admin.announcement.delete", methods="DELETE")
     * @param Announcement  $announcement
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Announcement $announcement, Request $request){
        $submittedToken = $request->request->get('token');
        if($this->isCsrfTokenValid('delete', $submittedToken)){
            $this->em->remove($announcement);
            $this->em->flush();
            $this->addFlash('success' , "Announcement Successfully deleted");
        }
        return $this->redirectToRoute('admin.announcements.index');
    }

}
