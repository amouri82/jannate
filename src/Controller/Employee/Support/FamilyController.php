<?php

namespace App\Controller\Employee\Support;

use App\Entity\Family;
use App\Entity\Note;
use App\Entity\Task;
use App\Repository\StatusRepository;
use App\Repository\RequestRepository;
use App\Repository\EmployeeRepository;
use App\Repository\FamilyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\EmployeeCategoryRepository;

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
     * @var EmployeeCategoryRepository
    */
    private $employeeCatRepository;

    /**
     * @var StatusRepository
     */
    private $statusRepository;

    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;


    public function __construct(
        FamilyRepository $repository,
        StatusRepository $statusRepository,
        RequestRepository $requestRepository,
        EntityManagerInterface $em,
        EmployeeCategoryRepository $employeeCatRepository,
        EmployeeRepository $employeeRepository
    ) {
        $this->repository = $repository;
        $this->statusRepository = $statusRepository;
        $this->requestRepository = $requestRepository;
        $this->employeeCatRepository = $employeeCatRepository;
        $this->employeeRepository = $employeeRepository;
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
        $employee_categories = $this->employeeCatRepository->findAll();

        $familyRequests = $this->requestRepository->count(['parent' => $family->getId()]);

        return $this->render('employee/support/family/view.html.twig', [
            'family' => $family,
            'countRequests' => $familyRequests,
            'employee_categories' => $employee_categories
        ]);
    }

   /**
     * @Route("/employee/support/family/deactive/{id}", name="support.family.deactive")
     * @param Family  $family
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deactive(Family $family, Request $request)
    {

        $family->setDeactivationDate(new \DateTime('now'));
        $status = $this->getStatusbyStatusId(4);
        $family->setStatus($status);
        $message = "Family account successfully deactivated";       
        $this->em->persist($family);
        $this->em->flush();
        $this->addFlash('success', $message);
        $this->saveNote($family, $request);

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    /**
     * @Route("/employee/support/family/active/{id}", name="support.family.active")
     * @param Family  $family
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function active(Family $family, Request $request)
    {

        $family->setDeactivationDate(new \DateTime('now'));
        $status = $this->getStatusbyStatusId(1);
        $family->setStatus($status);
        $message = "Family account successfully activated";       
        $this->em->persist($family);
        $this->em->flush();
        $this->addFlash('success', $message);

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }    

    /**
     * @Route("/employee/support/family/onholiday/{id}", name="support.family.onholiday")
     * @param Family  $family
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function makeOnHoliday(Family $family, Request $request)
    {
        $leaving_date = $request->request->get('leaving_date');
        $family->setLeaveDate(new \DateTime($leaving_date));
        $status = $this->getStatusbyStatusId(3);
        $family->setStatus($status);
        $message = "Family account successfully leaved on holidays";       
        $this->em->persist($family);
        $this->em->flush();
        $this->addFlash('success', $message);

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }   
    
    /**
     * @Route("/employee/support/family/offholiday/{id}", name="support.family.offholiday")
     * @param Family  $family
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function makeOffHoliday(Family $family, Request $request)
    {
        $status = $this->getStatusbyStatusId(1);
        $family->setStatus($status);
        $message = "Family account successfully return back from holiday";       
        $this->em->persist($family);
        $this->em->flush();
        $this->addFlash('success', $message);

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }      

    /**
     * @param int $status_id
     */
    private function getStatusbyStatusId($status_id)
    {
        return $this->statusRepository->find($status_id);
    }

    /**
     * @Route("/employee/support/request/changeTrialDate", name="suport.family.changeTrialDate")
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

    /**
     * @Route("/v/family/addnote/{id}", name="support.family.addnote")
     * @param Family  $family
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addNote(Family $family, Request $request)
    {
        $this->saveNote($family, $request);
        $this->addFlash('success', 'Note successfully added');
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    /**
     * @param Family  $family
     * @param Request $request
     */
    private function saveNote(Family $family, Request $request)
    {
        $note = new Note();
        
        $comment = $request->request->get('comment');
        date_default_timezone_set("Asia/Karachi");
        $time = date('h:i a', time());

        $note->setComment($comment);
        $note->setFamily($family);
        $note->setUser($this->getUser());
        $note->setTime(new \DateTime($time));

        $this->em->persist($note);
        $this->em->flush();
    }

    /**
     * @Route("/employee/support/request/employees-by-category", name="support.family.employees_by_category")
     * @param Request $request
     *
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function employeesByCategory(Family $family = null, Request $request)
    {
        $category_id = $request->request->get('category_id');
        $category = $this->employeeCatRepository->find($category_id);
        $employees = $this->employeeRepository->findBy(['category' => $category, 'active' => 1]);
        count($employees);
        $employeesData = [];
        foreach ($employees as $employee) {
            $employeesData[] = ['key' => $employee->getId(), 'value' => $employee->getName()];
        }
        
        $response = new JsonResponse(["employees" => $employeesData]);

        return $response;
    }

    /**
     * @Route("/employee/support/family/addtask/{id}", name="support.family.addtask")
     * @param Family  $family
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addTask(Family $family, Request $request)
    {
        $task = new Task();
        $comment = $request->request->get('comment');
        $employee_id = $request->request->get('employees');
        $employee = $this->employeeRepository->find($employee_id);

        $task->setMessage($comment);
        $task->setFamily($family);
        $task->setEmployee($employee);

        $this->em->persist($task);
        $this->em->flush();
        $this->addFlash('success', 'Task successfully added');
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }    


}
