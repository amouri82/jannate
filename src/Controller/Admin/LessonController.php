<?php

namespace App\Controller\Admin;

use App\Entity\Lesson;
use App\Form\LessonType;
use App\Repository\CourseRepository;
use App\Repository\LessonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LessonController extends AbstractController
{

    /**
     * @var LessonRepository
     */
    private $repository;

    /**
     * @var CourseRepository
     */
    private $courseRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * LessonController constructor.
     *
     * @param LessonRepository       $repository
     * @param CourseRepository       $courseRepository
     * @param EntityManagerInterface $em
     */
    public function __construct(
        LessonRepository $repository,
        CourseRepository $courseRepository,
        EntityManagerInterface $em
    ) {
        $this->repository = $repository;
        $this->courseRepository = $courseRepository;
        $this->em = $em;
    }

    public function index()
    {
        return $this->render('admin/lesson/index.html.twig', [
            'controller_name' => 'LessonController',
        ]);
    }

    /**
     * @Route("/admin/lesson/new/{course_id}/{id}", name="admin.lesson.new")
     * @Route("/admin/lesson/{id}", name="admin.lesson.edit")
     * @param Request     $request
     * @param             $course_id
     * @param null        $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, $course_id, $id = null)
    {
        $new = true;
        $lesson = new Lesson();
        $course = $this->courseRepository->find($course_id);
        $form = $this->createForm(LessonType::class, $lesson,
            ['attr' => ['course_id' => $course_id]]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $lesson->setCourse($course);
            $this->em->persist($lesson);
            $this->em->flush();
            if ($new) {
                $this->addFlash('success', "Lesson successfully created");
            } else {
                $this->addFlash('success', "Lesson successfully updated");
            }
        }
        return $this->render('admin/lesson/create.html.twig', [
            'controller_name' => 'LessonController',
            'form' => $form->createView(),
            'course_id' => $course_id,
            'new' => $new
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="admin.lesson.delete", methods="DELETE")
     * @param Lesson  $lesson
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Lesson $lesson, Request $request){
        $submittedToken = $request->request->get('token');
        if($this->isCsrfTokenValid('delete', $submittedToken)){
            $this->em->remove($lesson);
            $this->em->flush();
            $this->addFlash('success' , "Record Successfully deleted");
        }
        return $this->redirectToRoute('admin.course.index');
    }
}
