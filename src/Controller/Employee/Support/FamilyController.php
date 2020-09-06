<?php

namespace App\Controller\Employee\Support;

use App\Entity\Family;
use App\Repository\StatusRepository;
use App\Repository\RequestRepository;
use App\Form\FamilyType;
use App\Repository\FamilyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

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

    /**
     * @var StatusRepository
     */

    public function __construct(
        FamilyRepository $repository,
        StatusRepository $statusRepository,
        RequestRepository $requestRepository,
        EntityManagerInterface $em
    ) {
        $this->repository = $repository;
        $this->statusRepository = $statusRepository;
        $this->requestRepository = $requestRepository;
        $this->em = $em;
    }

    /**
     * @Route("/employee/support/families", name="support.families.index")
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
            $this->repository->findAll(),
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
        return $this->render('employee/support/family/index.html.twig', [
            'regulars' => $regulars,
            'suspended' => $suspended,
            'count' => $count
        ]);
    }

    /**
     * @Route("/employee/support/family/view/{id}", name="support.family.view")
     * @param Family  $family
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function view(Family $family, Request $request)
    {
        $familyRequests = $this->requestRepository->count(['parent' => $family->getId()]);

        return $this->render('employee/support/family/view.html.twig', [
            'family' => $family,
            'countRequests' => $familyRequests
        ]);
    }

    /**
     * @Route("/employee/support/family/status", name="support.family.status")
     * @param Family  $family
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function status(Family $family, Request $request)
    {
        echo"papa";
        exit;

        if ($family->getActive()) {
            $family->setActive(0);
           // $family->setDeactivateAt(new \DateTime('now'));
            $message = "Family account successfully deactivated";
        } else {
            $family->setActive(1);
          //  $family->setDeactivateAt(null);
            $message = "Family account successfully activated";
        }


        $this->em->persist($family);
        $this->em->flush();
        $this->addFlash('success', $message);

        return $this->redirectToRoute(
            'support.family.view',
            ['id' => $family->getId()]
        );
    }

    /**
     * @Route("/employee/support/request/changeTrialDate", name="support.family.changeTrialDate")
     * @param Request $request
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function changeTrialDate(Request $request)
    {
        $family_id = $request->request->get('family_id');
        $date = $request->request->get('trialDate');

        $family = $this->repository->find((int) $family_id);
        $family->setTrialDate(new \DateTime($date));
        $this->em->persist($family);
        $this->em->flush();

        $response = new JsonResponse(["status" => "Success"]);
        return $response;
    }
}
