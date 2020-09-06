<?php

namespace App\Controller\Employee\Support;

use App\Entity\Employee;
use App\Entity\Student;
use App\Repository\EmployeeRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class StudentController extends AbstractController
{

    /**
     * @var StudentRepository
     */
    private $repository;

    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    public function __construct(
        StudentRepository $repository,
        EmployeeRepository $employeeRepository
    ) {
        $this->repository = $repository;
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @Route("/employee/support/students", name="support.students.index")
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /*
        $teacher = $this->employeeRepository->findOneBy(['user' => $this->getUser()->getId()]);

        $students = $this->repository->findBy(['teacher' => $teacher->getId()]);*/
        
        $students = $this->repository->findBy(['active' => 1]);
        // parameters to template/
        return $this->render('employee/support/student/index.html.twig', [
            'students' => $students,
        ]);
    }

    /**
     * @Route("/employee/support/studentcourse", name="support.student.studentcourse")
     * @param Request $request
     *
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function studentCourses(Request $request)
    {
        $student_id = $request->request->get('student_id');
        $student = $this->repository->find($student_id);
        $courses = $student->getCourse();
        $studentCourses = [];
        foreach ($courses as $course) {
            $studentCourses[] = ['key' => $course->getId(), 'value' => $course->getName()];
        }
        
        $response = new JsonResponse(["courses" => $studentCourses]);

        return $response;
    }
}
