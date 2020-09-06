<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Family
 *
 * @ORM\Table(name="family")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Family
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telephone", type="string", length=20, nullable=true)
     */
    private $telephone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mobile", type="string", length=20, nullable=true)
     */
    private $mobile;

    /**
     * @var string|null
     *
     * @ORM\Column(name="skype", type="string", length=30, nullable=true)
     */
    private $skype;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="string", length=30, nullable=true)
     */
    private $city;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="trial_date", type="datetime", nullable=true)
     */
    private $trialDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="regular_date", type="datetime", nullable=true)
     */
    private $regularDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="leave_date", type="datetime", nullable=true)
     */
    private $leaveDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deactivation_date", type="datetime", nullable=true)
     */
    private $deactivationDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="suspension_date", type="datetime", nullable=true)
     */
    private $suspensionDate;

    /**
     * @var string|null
     *
     * @ORM\Column(name="bank", type="string", length=100, nullable=true)
     */
    private $bank;

    /**
     * @var string|null
     *
     * @ORM\Column(name="student_bank", type="string", length=100, nullable=true)
     */
    private $studentBank;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Status")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\InvoiceType")
     */
    private $invoice_type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Student", mappedBy="family")
     */
    private $students;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Timezone")
     */
    private $timezone;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $payment_mode;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country")
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Currency")
     */
    private $currency;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $zoom;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist"}, orphanRemoval=true)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Request", mappedBy="parent")
     */
    private $requests;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $created_by;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Schedule", mappedBy="family", orphanRemoval=true)
     */
    private $schedule;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="family")
     */
    private $tasks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Note", mappedBy="family")
     */
    private $notes;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->requests = new ArrayCollection();
        $this->schedule = new ArrayCollection();
        $this->tasks = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getSkype(): ?string
    {
        return $this->skype;
    }

    public function setSkype(?string $skype): self
    {
        $this->skype = $skype;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getTrialDate(): ?\DateTimeInterface
    {
        return $this->trialDate;
    }

    public function setTrialDate(?\DateTimeInterface $trialDate): self
    {
        $this->trialDate = $trialDate;

        return $this;
    }

    public function getRegularDate(): ?\DateTimeInterface
    {
        return $this->regularDate;
    }

    public function setRegularDate(?\DateTimeInterface $regularDate): self
    {
        $this->regularDate = $regularDate;

        return $this;
    }

    public function getLeaveDate(): ?\DateTimeInterface
    {
        return $this->leaveDate;
    }

    public function setLeaveDate(?\DateTimeInterface $leaveDate): self
    {
        $this->leaveDate = $leaveDate;

        return $this;
    }

    public function getDeactivationDate(): ?\DateTimeInterface
    {
        return $this->deactivationDate;
    }

    public function setDeactivationDate(?\DateTimeInterface $deactivationDate): self
    {
        $this->deactivationDate = $deactivationDate;

        return $this;
    }

    public function getSuspensionDate(): ?\DateTimeInterface
    {
        return $this->suspensionDate;
    }

    public function setSuspensionDate(?\DateTimeInterface $suspensionDate): self
    {
        $this->suspensionDate = $suspensionDate;

        return $this;
    }

    public function getBank(): ?string
    {
        return $this->bank;
    }

    public function setBank(?string $bank): self
    {
        $this->bank = $bank;

        return $this;
    }

    public function getStudentBank(): ?string
    {
        return $this->studentBank;
    }

    public function setStudentBank(?string $studentBank): self
    {
        $this->studentBank = $studentBank;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getInvoiceType(): ?InvoiceType
    {
        return $this->invoice_type;
    }

    public function setInvoiceType(?InvoiceType $invoice_type): self
    {
        $this->invoice_type = $invoice_type;

        return $this;
    }

    /**
     * @return Collection|Student[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->setParent($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->contains($student)) {
            $this->students->removeElement($student);
            // set the owning side to null (unless already changed)
            if ($student->getParent() === $this) {
                $student->setParent(null);
            }
        }

        return $this;
    }

    public function getTimezone(): ?timezone
    {
        return $this->timezone;
    }

    public function setTimezone(?timezone $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function getPaymentMode(): ?string
    {
        return $this->payment_mode;
    }

    public function setPaymentMode(?string $payment_mode): self
    {
        $this->payment_mode = $payment_mode;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getZoom(): ?string
    {
        return $this->zoom;
    }

    public function setZoom(?string $zoom): self
    {
        $this->zoom = $zoom;

        return $this;
    }

    /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = new \DateTime("now");
    }

    /**
     * Gets triggered every time on update

     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime("now");
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Request[]
     */
    public function getRequests(): Collection
    {
        return $this->requests;
    }

    public function addRequest(Request $request): self
    {
        if (!$this->requests->contains($request)) {
            $this->requests[] = $request;
            $request->setParent($this);
        }

        return $this;
    }

    public function removeRequest(Request $request): self
    {
        if ($this->requests->contains($request)) {
            $this->requests->removeElement($request);
            // set the owning side to null (unless already changed)
            if ($request->getParent() === $this) {
                $request->setParent(null);
            }
        }

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->created_by;
    }

    public function setCreatedBy(?User $created_by): self
    {
        $this->created_by = $created_by;

        return $this;
    }

    /**
     * @return Collection|Schedule[]
     */
    public function getSchedule(): Collection
    {
        return $this->schedule;
    }

    public function addSchedule(Schedule $schedule): self
    {
        if (!$this->schedule->contains($schedule)) {
            $this->schedule[] = $schedule;
            $schedule->setFamily($this);
        }

        return $this;
    }

    public function removeSchedule(Schedule $schedule): self
    {
        if ($this->schedule->contains($schedule)) {
            $this->schedule->removeElement($schedule);
            // set the owning side to null (unless already changed)
            if ($schedule->getFamily() === $this) {
                $schedule->setFamily(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setFamily($this);
        }

        return $this;
    }

    public function removeTask(Task $task): self
    {
        if ($this->tasks->contains($task)) {
            $this->tasks->removeElement($task);
            // set the owning side to null (unless already changed)
            if ($task->getFamily() === $this) {
                $task->setFamily(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setFamily($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            // set the owning side to null (unless already changed)
            if ($note->getFamily() === $this) {
                $note->setFamily(null);
            }
        }

        return $this;
    }
}
