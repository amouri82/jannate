<?php

namespace App\Controller\Employee\Support;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\EmployeeRepository;
use App\Repository\StudentRepository;
use App\Repository\FamilyRepository;
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

    /**
     * @var FamilyRepository
     */
    private $familyRepository;    

    public function __construct(
        StudentRepository $repository,
        EmployeeRepository $employeeRepository,
        FamilyRepository $familyRepository
    ) {
        $this->repository = $repository;
        $this->employeeRepository = $employeeRepository;
        $this->familyRepository = $familyRepository;
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
     * @Route("/employee/support/student/new/{family_id}", name="support.student.new")
     * @Route("/employee/support/student/{family_id}/{id}", name="support.student.edit")
     * @param         $family_id
     * @param Student $student
     * @param Request $request
     *
     *
     * @return RedirectResponse|Response
     */

    public function create(
        Request $request,
        $family_id,
        Student $student = null
    ) {
        $new = false;
        if (!$student) {
            $student = new Student();
            $new = true;
        }

        $family = $this->familyRepository->find($family_id);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $student->setFamily($family);
            $this->em->persist($student);
            $this->em->flush();
            if ($new) {
                $this->addFlash('success', "Student successfully created");
            } else {
                $this->addFlash('success', "Student successfully updated");
            }
            return $this->redirectToRoute('support.students.index');
        }
        return $this->render('employee/support/student/create.html.twig', [
            'form' => $form->createView(),
            'new' => $new
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
