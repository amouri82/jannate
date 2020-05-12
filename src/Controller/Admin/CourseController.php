<?php

namespace App\Controller\Admin;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseCategoryRepository;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CourseController extends AbstractController
{
    /**
     * @var CourseRepository
     */
    private $repository;

    /**
     * @var CourseCategoryRepository
     */
    private $categoryRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        CourseRepository $repository,
        CourseCategoryRepository $categoryRepository,
        EntityManagerInterface $em
    ) {
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/course", name="admin.course.index")
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {

        $categories = $this->categoryRepository->findAll();
        $items = [];
        foreach ($categories as $category) {
            $course['category'] = $category;
            $course['courses']
                = $this->repository->findBy(['course_category' => $category->getId()]);;
            $items[] = $course;
        }

        // parameters to template
        return $this->render('admin/course/index.html.twig', [
            'items' => $items,
            'controller_name' => 'courseController'
        ]);
    }

    /**
     * @Route("/admin/course/new", name="admin.course.new")
     * @Route("/admin/course/{id}", name="admin.course.edit")
     * @param Course|null $course
     * @param Request     $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Course $course = null, Request $request)
    {
        $new = false;
        if (!$course) {
            $course = new Course();
            $new = true;
        }

        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($course);
            $this->em->flush();
            if ($new) {
                $this->addFlash('success', "Course successfully created");
            } else {
                $this->addFlash('success', "Course successfully updated");
            }
            return $this->redirectToRoute('admin.course.index');
        }
        return $this->render('admin/course/create.html.twig', [
            'form' => $form->createView(),
            'course' => $course,
            'new' => $new
        ]);
    }

    /**
     * @Route("/admin/course/lessons/{id}", name="admin.course.lessons")
     * @param Course $course
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function lessons(Course $course)
    {
        return $this->render('admin/course/lessons.html.twig', [
            'controller_name' => 'courseController',
            'lessons' => $course->getLessons(),
            'course' => $course
        ]);
    }

}
