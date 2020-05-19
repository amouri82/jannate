<?php

namespace App\Controller\Admin;

use App\Entity\Country;
use App\Entity\Timezone;
use App\Form\TimezoneType;
use App\Repository\TimezoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TimezoneController extends AbstractController
{
    /**
     * @var TimezoneRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        TimezoneRepository $repository,
        EntityManagerInterface $em
    ) {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/timezones/country/{country_id}", name="admin.timezones.country")
     * @Route("/admin/timezones", name="admin.timezones.index")
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @param null               $country_id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(
        PaginatorInterface $paginator,
        Request $request,
        $country_id = null
    ) {

        if ($country_id) {
            $filter = $this->repository->findBy(['country' => $country_id]);
        } else {
            $filter = $this->repository->findAll();
        }

        $count = count($filter);
        $timezones = $paginator->paginate(
            $filter,
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );

        // parameters to template
        return $this->render('admin/timezone/index.html.twig', [
            'timezones' => $timezones,
            'count' => $count
        ]);
    }

    /**
     * @Route("/admin/timezone/new", name="admin.timezone.new")
     * @Route("/admin/timezone/{id}", name="admin.timezone.edit")
     * @param Timezone $timezone
     * @param Request  $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Timezone $timezone = null, Request $request)
    {
        $new = false;
        if (!$timezone) {
            $timezone = new Timezone();
            $new = true;
        }

        $form = $this->createForm(TimezoneType::class, $timezone);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($timezone);
            $this->em->flush();
            if ($new) {
                $this->addFlash('success', "Timezone successfully created");
            } else {
                $this->addFlash('success', "Timezone successfully updated");
            }
            return $this->redirectToRoute('admin.timezones.index');
        }
        return $this->render('admin/timezone/create.html.twig', [
            'form' => $form->createView(),
            'new' => $new
        ]);
    }

    /**
     * @Route("/admin/timezone/delete/{id}", name="admin.timezone.delete", methods="DELETE")
     * @param Timezone $timezone
     * @param Request  $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Timezone $timezone, Request $request)
    {
        $submittedToken = $request->request->get('token');
        if ($this->isCsrfTokenValid('delete', $submittedToken)) {
            $this->em->remove($timezone);
            $this->em->flush();
            $this->addFlash('success', "Record Successfully deleted");
        }
        return $this->redirectToRoute('admin.timezones.index');
    }

}
