<?php

namespace App\Controller\Admin;

use App\Entity\Family;
use App\Entity\Note;
use App\Entity\Task;
use App\Repository\StatusRepository;
use App\Repository\RequestRepository;
use App\Repository\EmployeeRepository;
use App\Form\FamilyType;
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
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param array|null $createAccountData
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(
        Family $family = null,
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        array $createAccountData = null
    ) {
        $originalPassword = '';
        $new = false;

        if (!$family) {
            $family = new Family();
            $new = true;
            if ($createAccountData) {
                $family->setName($createAccountData['name']);
                $family->setEmail($createAccountData['email']);
                $family->setTelephone($createAccountData['phone']);
                $family->setCity($createAccountData['city']);
            }
        } else {
            $originalPassword = $family->getUser()->getPassword();    # encoded password
        }

        // build the form with user data
        $form = $this->createForm(FamilyType::class, $family);
        /* Remove User roles dropdown */
        $userForm = $form->get('user');
        $userForm->remove('roles');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Encode the password if needed
            # password has changed
            if (!empty($userForm->get('plainPassword')->getData())) {
                $password = $passwordEncoder->encodePassword($family->getUser(), $family->getUser()->getPlainPassword());
                $family->getUser()->setPassword($password);
            # password not changed
            } else {
                $family->getUser()->setPassword($originalPassword);
            }
            
            // if new family, set status on trial
            if ($new) {
                $trial = $this->statusRepository->findOneByName('On Trial');
                $family->setStatus($trial);
            }
            
            // Set User role
            $family->getUser()->setRoles(['ROLE_USER']);
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
        $employee_categories = $this->employeeCatRepository->findAll();

        $familyRequests = $this->requestRepository->count(['parent' => $family->getId()]);

        return $this->render('admin/family/view.html.twig', [
            'family' => $family,
            'countRequests' => $familyRequests,
            'employee_categories' => $employee_categories
        ]);
    }

    /**
     * @Route("/admin/family/deactive/{id}", name="admin.family.deactive")
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

        return $this->redirectToRoute(
            'admin.family.view',
            ['id' => $family->getId()]
        );
    }

    /**
     * @Route("/admin/family/active/{id}", name="admin.family.active")
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

        return $this->redirectToRoute(
            'admin.family.view',
            ['id' => $family->getId()]
        );
    }    

    /**
     * @Route("/admin/family/onholiday/{id}", name="admin.family.onholiday")
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

        return $this->redirectToRoute(
            'admin.family.view',
            ['id' => $family->getId()]
        );
    }   
    
    /**
     * @Route("/admin/family/offholiday/{id}", name="admin.family.offholiday")
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

        return $this->redirectToRoute(
            'admin.family.view',
            ['id' => $family->getId()]
        );
    }      

    /**
     * @param int $status_id
     */
    private function getStatusbyStatusId($status_id)
    {
        return $this->statusRepository->find($status_id);
    }

    /**
     * @Route("/admin/request/changeTrialDate", name="admin.family.changeTrialDate")
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
     * @Route("/admin/family/addnote/{id}", name="admin.family.addnote")
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
     * @Route("/admin/request/employees-by-category", name="admin.family.employees_by_category")
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
     * @Route("/admin/family/addtask/{id}", name="admin.family.addtask")
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
