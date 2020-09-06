<?php

namespace App\Controller\Employee\Support;

use App\Entity\Employee;
use App\Entity\Schedule;
use App\Form\EmployeeType;
use App\Form\ScheduleType;
use App\Repository\CourseRepository;
use App\Repository\EmployeeRepository;
use App\Repository\StudentRepository;
use App\Repository\TimeRepository;
use App\Repository\ScheduleRepository;
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
use Symfony\Component\HttpFoundation\JsonResponse;
use \Exception;

class TeacherController extends AbstractController
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
     * @var TimeRepository
     */
    private $timeRepository;   
    
    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * @var CourseRepository
     */
    private $courseRepository;

    /**
     * @var ScheduleRepository
     */
    private $scheduleRepository;

    public function __construct(
        EmployeeRepository $repository,
        EntityManagerInterface $em,
        TimeRepository $timeRepository,
        StudentRepository $studentRepository,
        CourseRepository $courseRepository,
        ScheduleRepository $scheduleRepository        
    ) {
        $this->repository = $repository;
        $this->em = $em;
        $this->timeRepository = $timeRepository;
        $this->studentRepository = $studentRepository;
        $this->courseRepository = $courseRepository;
        $this->scheduleRepository = $scheduleRepository;
    }

    /**
     * @Route("/employee/support/teachers", name="support.teachers.index")
     * @param PaginatorInterface $paginator
     * @param Request            $request
     *
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $count = $this->repository->count([]);
        $teachers = $paginator->paginate(
            $this->repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        // parameters to template
        return $this->render('/employee/support/teacher/index.html.twig', [
            'teachers' => $teachers,
            'count' => $count
        ]);
    }

    /**
     * @Route("/employee/support/teacher/{id}", name="support.teacher.edit")
     * @param Employee                     $teacher
     * @param Request                      $request
     *
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return RedirectResponse|Response
     */
    public function edit(
        Employee $teacher,
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        if (!$teacher) {
            $this->addFlash('error', "Teacher doesn't exist");
        }

        $form = $this->createForm(EmployeeType::class, $teacher);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword(
                $teacher->getUser(),
                $teacher->getUser()->getPlainPassword()
            );
            $teacher->getUser()->setPassword($password);

            $this->em->persist($teacher);
            $this->em->flush();
            $this->addFlash('success', "Teacher successfully updated");
            return $this->redirectToRoute('support.teachers.index');
        }
        return $this->render('employee/support/teacher/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/employee/support/teacher/view/{id}", name="support.teacher.view")
     * @param Employee $teacher
     * @param Request  $request
     *
     * @return RedirectResponse|Response
     */
    public function view(Employee $teacher, Request $request)
    {
        $form = $this->createFormBuilder($teacher)
            ->add('avatarFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'asset_helper' => true,
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teacher->setAvatarFile(($form['avatarFile']->getData()));
            $this->em->persist($teacher);
            $this->em->flush();
            $this->addFlash('success', "Profile image successfully updated");
        }

        return $this->render('employee/support/teacher/view.html.twig', [
            'teacher' => $teacher,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/employee/support/teacher/status/{id}", name="support.teacher.status")
     * @param Employee $teacher
     * @param Request  $request
     *
     * @return RedirectResponse
     */
    public function status(Employee $teacher, Request $request)
    {
        if ($teacher->getActive()) {
            $teacher->setActive(0);
            $teacher->setDeactivateAt(new DateTime('now'));
            $message = "Employee account successfully deactivated";
        } else {
            $teacher->setActive(1);
            $teacher->setDeactivateAt(null);
            $message = "Employee account successfully activated";
        }


        $this->em->persist($teacher);
        $this->em->flush();
        $this->addFlash('success', $message);

        return $this->redirectToRoute(
            'admin.employee.view',
            ['id' => $teacher->getId()]
        );
    }

    /**
     * @Route("/employee/support/teacher/schedule/{id}", name="support.teacher.schedule")
     * @param Employee $teacher
     * @param Request  $request
     *
     * @return RedirectResponse|Response
     */
    public function schedule(Employee $teacher, Request $request)
    {    
        $schedules = $this->timeRepository->getTeacherTimes($teacher);
        return $this->render('employee/support/teacher/schedule.html.twig', [
            'teacher' => $teacher,
            'schedules' => $schedules,
        ]);
    }


    /**
     * @Route("/employee/support/teacher/timeslot/{teacher}/{id}", name="support.teacher.timeslot")
     * @param Schedule $schedule
     * @param int $teacher
     * @param Request  $request
     *s
     * @return RedirectResponse|Response
     */    
    public function timeSlot(Schedule $schedule = null, Employee $teacher, Request $request)
    {
        if(!$schedule) {
            $schedule = new Schedule();
        }

        $form = $this->createForm(ScheduleType::class, $schedule);
        $form->handleRequest($request);
        return $this->render('employee/support/teacher/modal-schedule.html.twig', [
            'form' => $form->createView()
        ]);                    
    }

    /**
     * @Route("/employee/support/teacher/addschedule/{id}", name="support.teacher.addschedule")
     * @param Request $request
     * @param Employee $teacher
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addSchedule(Employee $teacher, Request $request)
    {
        
        try {
            parse_str($request->getContent(), $form);

            $schedule = null;
            $student = $this->studentRepository->find( (int) $form['student'] );      
            $course = $this->courseRepository->find( (int) $form['student-course'] );            

            if ($form['schedule_id']) {
                $schedule = $this->scheduleRepository->find($form['schedule_id']);
            }

            if($schedule) {
                $day = $schedule->getDay();
                $this->saveSchedule($schedule, $teacher, $student, $day, $course, $form);
            } else {
                foreach($form['daysCheckbox'] as $day) {
                    $schedule = new Schedule();
                    $this->saveSchedule($schedule, $teacher, $student, $day, $course, $form);
                }
            }
            
            $response = ['status' => 'success'];

        } catch(Exception $e) {
            $response = ['status' => 'error', 'message' => $e->getMessage()];
        }
        
        $response = new JsonResponse($response);
        return $response;
    }   
    
    private function saveSchedule($schedule, $teacher, $student, $day, $course, $form)
    {
        $schedule->setTeacher($teacher);
        $schedule->setStudent($student);
        $schedule->setFamily($student->getFamily());            
        $schedule->setTimeStart(new \DateTime($form['start_time']));
        $schedule->setTimeEnd(new \DateTime($form['end_time']));            
        $schedule->setAdminTimeStart(new \DateTime($form['start_time']));
        $schedule->setAdminTimeEnd(new \DateTime($form['end_time']));    
        $schedule->setStudentTimeStart(new \DateTime($form['start_time']));
        $schedule->setStudentTimeEnd(new \DateTime($form['end_time']));
        $schedule->setDay($day);
        $schedule->setStudentDay($day);
        $schedule->setAdminDay($day);
        $schedule->setCourse($course);
        $schedule->setPhpTz($student->getFamily()->getTimezone()->getPhpTimezone());
        $duration = $schedule->getTimeStart()->diff($schedule->getTimeEnd());
        $duration = $duration->format("%H:%i");
        $schedule->setDuration(new \DateTime($duration));
        $this->em->persist($schedule);
        $this->em->flush();        
    }
}