<?php

namespace App\Controller\Admin;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Repository\EmployeeCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;


class TaskController extends AbstractController
{

    /**
     * @var TaskRepository
     */
    private $repository;
    
    /** 
     * @var EmployeeCategoryRepository
    */
    private $employeeCatRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        TaskRepository $repository,
        EntityManagerInterface $em,
        EmployeeCategoryRepository $employeeCatRepository
    ) {
        $this->repository = $repository;
        $this->employeeCatRepository = $employeeCatRepository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/tasks", name="admin.tasks.index")
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $count = $this->repository->count([]);        
        $tasks = $paginator->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );
        // parameters to template
        return $this->render('admin/task/index.html.twig', [
            'tasks' => $tasks,
            'count' => $count
        ]);
    }

    /**
     * @Route("/admin/task/new", name="admin.task.new")
     * @param Task  $task
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Task $task = null, Request $request)
    {
        $employee_categories = $this->employeeCatRepository->findAll();

        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($task);
            $this->em->flush();
            $this->addFlash('success' , "Task successfully created");            
            return $this->redirectToRoute('support.task.new');
        }
        return $this->render('employee/support/Task/create.html.twig', [
            'form' => $form->createView(),
            'employee_categories' => $employee_categories
        ]);
    }

    /**
     * @Route("/admin/task/delete/{id}", name="admin.task.delete", methods="DELETE")
     * @param task  $task
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(task $task, Request $request){
        $submittedToken = $request->request->get('token');
        if($this->isCsrfTokenValid('delete', $submittedToken)){
            $this->em->remove($task);
            $this->em->flush();
            $this->addFlash('success' , "task Successfully deleted");
        }
        return $this->redirectToRoute('admin.tasks.index');
    }    
}
