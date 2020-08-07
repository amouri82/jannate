<?php

namespace App\Controller\Admin;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\FamilyRepository;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception as ExceptionAlias;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var FamilyRepository
     */
    private $familyRepository;

    public function __construct(
        StudentRepository $repository,
        EntityManagerInterface $em,
        FamilyRepository $familyRepository
    ) {
        $this->repository = $repository;
        $this->em = $em;
        $this->familyRepository = $familyRepository;
    }

    /**
     * @Route("/admin/students", name="admin.students.index")
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $students = $paginator->paginate(
            $this->repository->findBy(['status' => 1]),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        $inActivestudents = $paginator->paginate(
            $this->repository->findBy(['status' => 0]),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        // parameters to template
        return $this->render('admin/student/index.html.twig', [
            'students' => $students,
            'inActiveStudents' => $inActivestudents
        ]);
    }

    /**
     * @Route("/admin/student/new/{family_id}", name="admin.student.new")
     * @Route("/admin/student/{family_id}/{id}", name="admin.student.edit")
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
            return $this->redirectToRoute('admin.students.index');
        }
        return $this->render('admin/student/create.html.twig', [
            'form' => $form->createView(),
            'new' => $new
        ]);
    }

    /**
     * @Route("/admin/student/delete/{id}", name="admin.student.delete", methods="DELETE")
     * @param Student $student
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function delete(Student $student, Request $request)
    {
        $submittedToken = $request->request->get('token');
        if ($this->isCsrfTokenValid('delete', $submittedToken)) {
            $this->em->remove($student);
            $this->em->flush();
            $this->addFlash('success', "Record Successfully deleted");
        }
        return $this->redirectToRoute('admin.students.index');
    }


    /**
     * @Route("/admin/student/status/{id}", name="admin.student.status")
     * @param Student $student
     *
     * @return RedirectResponse
     * @throws ExceptionAlias
     */
    public function status(Student $student)
    {
        /*
                if ($student->getActive()) {
                    $student->setActive(0);
                    $student->setDeactivateAt(new \DateTime('now'));
                    $message = "Student account successfully deactivated";
                } else {
                    $student->setActive(1);
                    $student->setDeactivateAt(null);
                    $message = "Student account successfully activated";
                }
        */
        $message = '';
        $this->em->persist($student);
        $this->em->flush();
        $this->addFlash('success', $message);

        return $this->redirectToRoute('admin.Student.view',
            ['id' => $student->getId()]);
    }

}
