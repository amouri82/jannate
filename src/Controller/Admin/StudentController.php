<?php

namespace App\Controller\Admin;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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

    public function __construct(
        StudentRepository $repository,
        EntityManagerInterface $em
    ) {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/students", name="admin.students.index")
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $count = $this->repository->count([]);
        $students = $paginator->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        // parameters to template
        return $this->render('admin/student/index.html.twig', [
            'students' => $students,
            'count' => $count
        ]);
    }

    /**
     * @Route("/admin/student/new", name="admin.student.new")
     * @Route("/admin/student/{id}", name="admin.student.edit")
     * @param Student                     $student
     * @param Request                      $request
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Student $student = null, Request $request,  UserPasswordEncoderInterface $passwordEncoder)
    {
        $new = false;
        if(!$student) {
            $student = new Student();
            $new = true;
        }

        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // 3) Encode the password (you could also do this via Doctrine listener)
            //$password = $passwordEncoder->encodePassword($student, $student->getPlainPassword());
            $password = $student->getPlainPassword();
            $student->setPassword($password);

            $this->em->persist($student);
            $this->em->flush();
            if($new) {
                $this->addFlash('success' , "Student successfully created");
            } else {
                $this->addFlash('success' , "Student successfully updated");
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
     * @param Request  $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Student $student, Request $request){
        $submittedToken = $request->request->get('token');
        if($this->isCsrfTokenValid('delete', $submittedToken)){
            $this->em->remove($student);
            $this->em->flush();
            $this->addFlash('success' , "Record Successfully deleted");
        }
        return $this->redirectToRoute('admin.students.index');
    }

    /**
     * @Route("/admin/student/view/{id}", name="admin.student.view")
     * @param Student $student
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function view(Student $student, Request $request)
    {
        return $this->render('admin/Student/view.html.twig', [
            'Student' => $student
        ]);
    }

    /**
     * @Route("/admin/student/status/{id}", name="admin.student.status")
     * @param Student $student
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function status(Student $student, Request $request){

        if ($student->getActive()) {
            $student->setActive(0);
            $student->setDeactivateAt(new \DateTime('now'));
            $message = "Student account successfully deactivated";
        } else {
            $student->setActive(1);
            $student->setDeactivateAt(null);
            $message = "Student account successfully activated";
        }


        $this->em->persist($student);
        $this->em->flush();
        $this->addFlash('success' , $message);

        return $this->redirectToRoute('admin.Student.view', array('id' => $student->getId()));
    }

}
