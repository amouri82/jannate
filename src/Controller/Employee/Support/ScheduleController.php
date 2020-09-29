<?php

namespace App\Controller\Employee\Support;

use App\Repository\EmployeeRepository;
use App\Repository\StudentRepository;
use App\Repository\ScheduleRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Exception;

class ScheduleController extends AbstractController
{

    /**
     * @var EmployeeRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;
   
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * @var ScheduleRepository
     */
    private $scheduleRepository;

    public function __construct(
        EmployeeRepository $repository,
        EntityManagerInterface $em,
        StudentRepository $studentRepository,
        ScheduleRepository $scheduleRepository        
    ) {
        $this->repository = $repository;
        $this->em = $em;
        $this->studentRepository = $studentRepository;
        $this->scheduleRepository = $scheduleRepository;
    }


    /**
     * @Route("/support/schedule/delete", name="support.schedule.delete", methods="DELETE")
     * @param Request  $request
     *
     * @return RedirectResponse
     */
    public function delete(Request $request)
    {
        $schedule_id = $request->request->get('schedule_id');
        $schedule = $this->scheduleRepository->find($schedule_id);
        $submittedToken = $request->request->get('token');
        if ($this->isCsrfTokenValid('delete', $submittedToken)) {
            $this->em->remove($schedule);
            $this->em->flush();
            $this->addFlash('success', "Record Successfully deleted");
        }
        $referer = $request->headers->get('referer');       
        return $this->redirect($referer);

    }

    /**
     * @Route("/support/schedule/deleteAll", name="support.schedule.deleteAll", methods="DELETE")
     * @param Request  $request
     *
     * @return RedirectResponse
     */
    public function deleteAll(Request $request)
    {
        $student_id = $request->request->get('student_id');
        $student = $this->studentRepository->find($student_id);
        $submittedToken = $request->request->get('token');
        if ($this->isCsrfTokenValid('delete', $submittedToken)) {
            $this->scheduleRepository->deleteStudentSchedules($student);          
            $this->em->flush();
            $this->addFlash('success', "Record Successfully deleted");
        }
        $referer = $request->headers->get('referer');       
        return $this->redirect($referer);

    }

    /**
     * @param string $date
     * @return Response
     */    
    public function schedules($date = null) 
    {
        $date = $date ?? date('Y-m-d');
        $schedules = $this->scheduleRepository->findBy(['create_date_admin' => new \DateTime($date)]);

        return $this->render('employee/support/schedule/schedules.html.twig', [
            'schedules' => $schedules,
            'date' => $date
        ]);
        
    } 
}