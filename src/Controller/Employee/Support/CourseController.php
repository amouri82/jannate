<?php

namespace App\Controller\Employee\Support;

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
     * @Route("/employee/support/courses", name="support.courses.index")
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
        return $this->render('employee/support/course/index.html.twig', [
            'items' => $items,
            'controller_name' => 'courseController'
        ]);
    }

    /**
     * @Route("/employee/support/course/lessons/{id}", name="support.course.lessons")
     * @param Course $course
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function lessons(Course $course)
    {
        return $this->render('employee/support/course/lessons.html.twig', [
            'controller_name' => 'courseController',
            'lessons' => $course->getLessons(),
            'course' => $course
        ]);
    }

}
