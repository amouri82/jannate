<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee", inversedBy="tasks")
     */
    private $employee;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Family", inversedBy="tasks")
     */
    private $family;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TaskString", mappedBy="task", orphanRemoval=true)
     */
    private $taskStrings;

    public function __construct()
    {
        $this->taskStrings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Gets triggered only on insert

     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created_at = new \DateTime("now");
        $this->status = 1;
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
     * @return Collection|TaskString[]
     */
    public function getTaskStrings(): Collection
    {
        return $this->taskStrings;
    }

    public function addTaskString(TaskString $taskString): self
    {
        if (!$this->taskStrings->contains($taskString)) {
            $this->taskStrings[] = $taskString;
            $taskString->setTask($this);
        }

        return $this;
    }

    public function removeTaskString(TaskString $taskString): self
    {
        if ($this->taskStrings->contains($taskString)) {
            $this->taskStrings->removeElement($taskString);
            // set the owning side to null (unless already changed)
            if ($taskString->getTask() === $this) {
                $taskString->setTask(null);
            }
        }

        return $this;
    }       
}
