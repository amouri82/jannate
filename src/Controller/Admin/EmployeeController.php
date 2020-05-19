<?php

namespace App\Controller\Admin;

use App\Entity\Employee;
use App\Entity\Sms;
use App\Form\EmployeeType;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
     * @return \Symfony\Component\HttpFoundation\Response
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
     * @param Sms  $employee
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Employee $employee = null, Request $request)
    {
        $new = false;
        if(!$employee) {
            $employee = new Employee();
            $new = true;
        }

        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($employee);
            $this->em->flush();
            if($new) {
                $this->addFlash('success' , "Employee successfully created");
            } else {
                $this->addFlash('success' , "Employee successfully updated");
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
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Employee $employee, Request $request){
        $submittedToken = $request->request->get('token');
        if($this->isCsrfTokenValid('delete', $submittedToken)){
            $this->em->remove($employee);
            $this->em->flush();
            $this->addFlash('success' , "Record Successfully deleted");
        }
        return $this->redirectToRoute('admin.employees.index');
    }

}
