<?php

namespace App\Controller\Admin;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Repository\EmployeeRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Vich\UploaderBundle\Form\Type\VichFileType;

class EmployeeController extends AbstractController
{

    /**
     * @var EmployeeRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        EmployeeRepository $repository,
        EntityManagerInterface $em
    ) {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin/employees", name="admin.employees.index")
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $count = $this->repository->count([]);
        $employees = $paginator->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        // parameters to template
        return $this->render('admin/employee/index.html.twig', [
            'employees' => $employees,
            'count' => $count
        ]);
    }

    /**
     * @Route("/admin/employee/new", name="admin.employee.new")
     * @Route("/admin/employee/{id}", name="admin.employee.edit")
     * @param Employee                     $employee
     * @param Request                      $request
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return RedirectResponse|Response
     */
    public function create(
        Employee $employee = null,
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $new = false;
        if (!$employee) {
            $employee = new Employee();
            $new = true;
        }

        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($employee->getUser(),
                $employee->getUser()->getPlainPassword());
            $employee->getUser()->setPassword($password);

            $this->em->persist($employee);
            $this->em->flush();
            if ($new) {
                $this->addFlash('success', "Employee successfully created");
            } else {
                $this->addFlash('success', "Employee successfully updated");
            }
            return $this->redirectToRoute('admin.employees.index');
        }
        return $this->render('admin/employee/create.html.twig', [
            'form' => $form->createView(),
            'new' => $new
        ]);
    }

    /**
     * @Route("/admin/employee/delete/{id}", name="admin.employee.delete", methods="DELETE")
     * @param Employee $employee
     * @param Request  $request
     *
     * @return RedirectResponse
     */
    public function delete(Employee $employee, Request $request)
    {
        $submittedToken = $request->request->get('token');
        if ($this->isCsrfTokenValid('delete', $submittedToken)) {
            $this->em->remove($employee);
            $this->em->flush();
            $this->addFlash('success', "Record Successfully deleted");
        }
        return $this->redirectToRoute('admin.employees.index');
    }

    /**
     * @Route("/admin/employee/view/{id}", name="admin.employee.view")
     * @param Employee $employee
     * @param Request  $request
     *
     * @return RedirectResponse|Response
     */
    public function view(Employee $employee, Request $request)
    {
        $form = $this->createFormBuilder($employee)
            ->add('avatarFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'asset_helper' => true,
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employee->setAvatarFile(($form['avatarFile']->getData()));
            $this->em->persist($employee);
            $this->em->flush();
            $this->addFlash('success', "Profile image successfully updated");
        }

        return $this->render('admin/employee/view.html.twig', [
            'employee' => $employee,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/employee/status/{id}", name="admin.employee.status")
     * @param Employee $employee
     * @param Request  $request
     *
     * @return RedirectResponse
     */
    public function status(Employee $employee, Request $request)
    {

        if ($employee->getActive()) {
            $employee->setActive(0);
            $employee->setDeactivateAt(new DateTime('now'));
            $message = "Employee account successfully deactivated";
        } else {
            $employee->setActive(1);
            $employee->setDeactivateAt(null);
            $message = "Employee account successfully activated";
        }


        $this->em->persist($employee);
        $this->em->flush();
        $this->addFlash('success', $message);

        return $this->redirectToRoute('admin.employee.view',
            ['id' => $employee->getId()]);
    }

}
