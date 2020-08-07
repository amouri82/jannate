<?php

namespace App\Controller\Admin;

use App\Entity\Family;
use App\Form\FamilyType;
use App\Repository\FamilyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class FamilyController extends AbstractController
{

    /**
     * @var FamilyRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        FamilyRepository $repository,
        EntityManagerInterface $em
    ) {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/families", name="admin.families.index")
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $count = $this->repository->count([]);
        // Regular Status
        $regulars = $paginator->paginate(
            $this->repository->findby(['status' => 1]),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        /* frees families */
        $frees = $paginator->paginate(
            $this->repository->findby(['status' => 5]),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        /* On trial families */
        $trials = $paginator->paginate(
            $this->repository->findby(['status' => 2]),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        /* Suspended families */
        $suspended = $paginator->paginate(
            $this->repository->findby(['status' => 5]),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        // parameters to template
        return $this->render('admin/family/index.html.twig', [
            'regulars' => $regulars,
            'frees' => $frees,
            'trials' => $trials,
            'suspended' => $suspended,
            'count' => $count
        ]);
    }

    /**
     * @Route("/admin/family/new", name="admin.family.new")
     * @Route("/admin/family/{id}", name="admin.family.edit")
     * @param Family                       $family
     * @param Request                      $request
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(
        Family $family = null,
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $new = false;
        if (!$family) {
            $family = new Family();
            $new = true;
        }
        // build the form with user data
        $originalPassword = $family->getUser()->getPassword();    # encoded password
        $form = $this->createForm(FamilyType::class, $family)->remove('user.username');

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Encode the password if needed
            # password has changed
            if (!empty($form->get('plainPassword')->getData())) {
                $password = $passwordEncoder->encodePassword($family->getUser(), $family->getUser()->getPlainPassword());
                $family->getUser()->setPassword($password);
                # password not changed
            } else {
                $family->getUser()->setPassword($originalPassword);
            }

            $this->em->persist($family);
            $this->em->flush();

            if ($new) {
                $this->addFlash('success', "Family successfully created");
            } else {
                $this->addFlash('success', "Family successfully updated");
            }
            return $this->redirectToRoute('admin.families.index');
        }
        return $this->render('admin/family/create.html.twig', [
            'form' => $form->createView(),
            'new' => $new
        ]);
    }

    /**
     * @Route("/admin/family/delete/{id}", name="admin.family.delete", methods="DELETE")
     * @param Family  $family
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Family $family, Request $request)
    {
        $submittedToken = $request->request->get('token');
        if ($this->isCsrfTokenValid('delete', $submittedToken)) {
            $this->em->remove($family);
            $this->em->flush();
            $this->addFlash('success', "Record Successfully deleted");
        }
        return $this->redirectToRoute('admin.families.index');
    }

    /**
     * @Route("/admin/family/view/{id}", name="admin.family.view")
     * @param Family  $family
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function view(Family $family, Request $request)
    {
        return $this->render('admin/family/view.html.twig', [
            'family' => $family
        ]);
    }

    /**
     * @Route("/admin/family/status", name="admin.family.status")
     * @param Family  $family
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function status(Family $family, Request $request)
    {

        echo"papa";exit;

        if ($family->getActive()) {
            $family->setActive(0);
            $family->setDeactivateAt(new \DateTime('now'));
            $message = "Family account successfully deactivated";
        } else {
            $family->setActive(1);
            $family->setDeactivateAt(null);
            $message = "Family account successfully activated";
        }


        $this->em->persist($family);
        $this->em->flush();
        $this->addFlash('success', $message);

        return $this->redirectToRoute('admin.family.view',
            ['id' => $family->getId()]);
    }



}
