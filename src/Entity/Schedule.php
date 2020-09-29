<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScheduleRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Schedule
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Room")
     */
    private $room;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee", inversedBy="schedule")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teacher;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Course")
     * @ORM\JoinColumn(nullable=false)
     */
    private $course;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Family", inversedBy="schedule")
     * @ORM\JoinColumn(nullable=false)
     */
    private $family;

    /**
     * @ORM\Column(type="time")
     */
    private $time_start;

    /**
     * @ORM\Column(type="time")
     */
    private $time_end;

    /**
     * @ORM\Column(type="time")
     */
    private $student_time_start;

    /**
     * @ORM\Column(type="time")
     */
    private $student_time_end;

    /**
     * @ORM\Column(type="time")
     */
    private $admin_time_start;

    /**
     * @ORM\Column(type="time")
     */
    private $admin_time_end;

    /**
     * @ORM\Column(type="time")
     */
    private $duration;

    /**
     * @ORM\Column(type="integer")
     */
    private $day;

    /**
     * @ORM\Column(type="integer")
     */
    private $student_day;

    /**
     * @ORM\Column(type="integer")
     */
    private $admin_day;

    /**
     * @ORM\Column(type="integer", options={"default"=1})
     */
    private $status;

    /**
     * @ORM\Column(type="date")
     */
    private $create_date_admin;

    /**
     * @ORM\Column(type="date")
     */
    private $create_date_teacher;

    /**
     * @ORM\Column(type="date")
     */
    private $create_date_student;

    /**
     * @ORM\Column(type="integer", options={"default"=21})
     */
    private $public_holiday;

    /**
     * @ORM\Column(type="integer", options={"default"=1})
     */
    private $rate;

    /**
     * @ORM\Column(type="integer", options={"default"=1})
     */
    private $student_rate;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $php_tz;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="schedules")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getTeacher(): ?Employee
    {
        return $this->teacher;
    }

    public function setTeacher(?Employee $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): self
    {
        $this->course = $course;

        return $this;
    }

    public function getFamily(): ?Family
    {
        return $this->family;
    }

    public function setFamily(?Family $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getTimeStart(): ?\DateTimeInterface
    {
        return $this->time_start;
    }

    public function setTimeStart(\DateTimeInterface $time_start): self
    {
        $this->time_start = $time_start;

        return $this;
    }

    public function getTimeEnd(): ?\DateTimeInterface
    {
        return $this->time_end;
    }

    public function setTimeEnd(\DateTimeInterface $time_end): self
    {
        $this->time_end = $time_end;

        return $this;
    }

    public function getStudentTimeStart(): ?\DateTimeInterface
    {
        return $this->student_time_start;
    }

    public function setStudentTimeStart(\DateTimeInterface $student_time_start): self
    {
        $this->student_time_start = $student_time_start;

        return $this;
    }

    public function getStudentTimeEnd(): ?\DateTimeInterface
    {
        return $this->student_time_end;
    }

    public function setStudentTimeEnd(\DateTimeInterface $student_time_end): self
    {
        $this->student_time_end = $student_time_end;

        return $this;
    }

    public function getAdminTimeStart(): ?\DateTimeInterface
    {
        return $this->admin_time_start;
    }

    public function setAdminTimeStart(\DateTimeInterface $admin_time_start): self
    {
        $this->admin_time_start = $admin_time_start;

        return $this;
    }

    public function getAdminTimeEnd(): ?\DateTimeInterface
    {
        return $this->admin_time_end;
    }

    public function setAdminTimeEnd(\DateTimeInterface $admin_time_end): self
    {
        $this->admin_time_end = $admin_time_end;

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->duration;
    }

    public function setDuration(\DateTimeInterface $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDay(): ?int
    {
        return $this->day;
    }

    public function setDay(int $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getStudentDay(): ?int
    {
        return $this->student_day;
    }

    public function setStudentDay(int $student_day): self
    {
        $this->student_day = $student_day;

        return $this;
    }

    public function getAdminDay(): ?int
    {
        return $this->admin_day;
    }

    public function setAdminDay(int $admin_day): self
    {
        $this->admin_day = $admin_day;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreateDateAdmin(): ?\DateTimeInterface
    {
        return $this->create_date_admin;
    }

    public function setCreateDateAdmin(\DateTimeInterface $create_date_admin): self
    {
        $this->create_date_admin = $create_date_admin;

        return $this;
    }

    public function getCreateDateTeacher(): ?\DateTimeInterface
    {
        return $this->create_date_teacher;
    }

    public function setCreateDateTeacher(\DateTimeInterface $create_date_teacher): self
    {
        $this->create_date_teacher = $create_date_teacher;

        return $this;
    }

    public function getCreateDateStudent(): ?\DateTimeInterface
    {
        return $this->create_date_student;
    }

    public function setCreateDateStudent(\DateTimeInterface $create_date_student): self
    {
        $this->create_date_student = $create_date_student;

        return $this;
    }    

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPublicHoliday(): ?int
    {
        return $this->public_holiday;
    }

    public function setPublicHoliday(int $public_holiday): self
    {
        $this->public_holiday = $public_holiday;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getStudentRate(): ?int
    {
        return $this->student_rate;
    }

    public function setStudentRate(int $student_rate): self
    {
        $this->student_rate = $student_rate;

        return $this;
    }

    public function getPhpTz(): ?string
    {
        return $this->php_tz;
    }

    public function setPhpTz(?string $php_tz): self
    {
        $this->php_tz = $php_tz;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->status = 1;
        $this->rate = 1;
        $this->student_rate = 1;
        $this->public_holiday = 21;
        $this->create_date_student = new \DateTime("now");
        $this->create_date_teacher = new \DateTime("now");
        $this->create_date_admin = new \DateTime("now");
    }    
}
