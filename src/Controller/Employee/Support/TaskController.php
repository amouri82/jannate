<?php

namespace App\Controller\Employee\Support;

use App\Entity\Task;
use App\Entity\TaskString;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Repository\EmployeeCategoryRepository;
use App\Repository\EmployeeRepository;
use App\Repository\TaskStringRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


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
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var TaskStringRepository
     */
    private $taskStringRepository;

    public function __construct(
        TaskRepository $repository,
        EntityManagerInterface $em,
        EmployeeCategoryRepository $employeeCatRepository,
        TaskStringRepository $taskStringRepository,
        EmployeeRepository $employeeRepository
    ) {
        $this->repository = $repository;
        $this->employeeCatRepository = $employeeCatRepository;
        $this->taskStringRepository = $taskStringRepository;
        $this->employeeRepository = $employeeRepository;
        $this->em = $em;
    }

    /**
     * @Route("/employee/support/tasks/index/{status}", name="support.tasks.index")
     * @param Request            $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index($status = 1, Request $request)
    {
        // Awaiting
        $countAwaiting = $this->repository->count(['status' => 1]);
        // Active
        $countActive = $this->repository->count(['status' => 2]);
        // Closed
        $countClosed = $this->repository->count(['status' => 3]);        
        
        $tasks = $this->repository->findBy(['status' => $status]);

        return $this->render('employee/support/task/index.html.twig', [
            'tasks' => $tasks,
            'countAwaiting' => $countAwaiting,
            'countActive' => $countActive,
            'countClosed' => $countClosed,
            'status' => $status
        ]);
    }

    /**
     * @Route("/employee/support/task/new", name="support.task.new")
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
        return $this->render('employee/support/task/create.html.twig', [
            'form' => $form->createView(),
            'employee_categories' => $employee_categories
        ]);
    }

    /**
     * @Route("/employee/support/task/delete/{id}", name="support.task.delete", methods="DELETE")
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
        return $this->redirectToRoute('support.tasks.index');
    }
    
    /**
     * @Route("/employee/support/task/string/{id}", name="support.task.string")
     * @param Task  $task
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function taskString(Task $task, Request $request)
    {
        $strings = $this->taskStringRepository->findBy(['task' => $task]);
        $employee_categories = $this->employeeCatRepository->findAll();

        return $this->render('employee/support/task/task-string.html.twig', [
            'task' => $task,
            'strings' => $strings,
            'employee_categories' => $employee_categories
        ]);
    }     

    /**
     * @Route("/employee/support/task/reallocate/{id}", name="support.task.reallocate")
     * @param Task  $task
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function reallocateTask(Task $task, Request $request)
    {        
        $comment = $request->request->get('comment');
        $employee_id = $request->request->get('employees');
        $employee = $this->employeeRepository->find($employee_id);
        
        // Update Task
        $task->setEmployee($employee);
        $this->em->persist($task);
        $this->em->flush();
        
        // Save Task String
        $taskString = new TaskString();
        $taskString->setTask($task);
        $taskString->setUser($this->getUser());
        $taskString->setMessage($comment);
        $this->em->persist($taskString);
        $this->em->flush();        

        $this->addFlash('success', 'Task successfully re-allocated');
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);

    }   
    

    /**
     * @Route("/employee/support/task/addComment/{id}", name="support.task.addComment")
     * @param Task  $task
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addComment(Task $task, Request $request)
    {        
        $comment = $request->request->get('comment');              
        // Save Task String
        $taskString = new TaskString();
        $taskString->setTask($task);
        $taskString->setUser($this->getUser());
        $taskString->setMessage($comment);
        $this->em->persist($taskString);
        $this->em->flush();        

        $this->addFlash('success', 'Task String successfully Added');
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);

    }       
    
    /**
     * @Route("/employee/support/task/close/{id}", name="support.task.close")
     * @param Task  $task
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function close(Task $task, Request $request)
    {        
        // Close Task
        $task->setStatus(3);
        $this->em->persist($task);
        $this->em->flush();
        
        $this->addFlash('success', 'Task successfully closed');
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);

    }      
}
