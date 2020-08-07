<?php

namespace App\Controller\Employee;

use App\Entity\Employee;
use App\Entity\Student;
use App\Repository\EmployeeRepository;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/employee/students", name="employee.students.index")
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $teacher = $this->employeeRepository->findOneBy(['user' => $this->getUser()->getId()]);

        $students = $this->repository->findBy(['teacher' => $teacher->getId()]);
        // parameters to template/
        return $this->render('employee/student/index.html.twig', [
            'students' => $students,
        ]);
    }
}
