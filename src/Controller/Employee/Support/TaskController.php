<?php

namespace App\Controller\Employee\Support;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
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
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        TaskRepository $repository,
        EntityManagerInterface $em
    ) {
        $this->repository = $repository;
        $this->em = $em;
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
            'form' => $form->createView()
        ]);
    }
}
