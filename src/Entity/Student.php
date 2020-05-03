<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 */
class Student
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $skype;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $language;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\Column(type="date")
     */
    private $joining_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $active;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $teacher_rate;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $teacher_remark;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $parent_remark;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $student_rate;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $gender;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Employee")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teacher;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $class_type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ParentAccount", inversedBy="students")
     * @ORM\JoinColumn(nullable=false)
     */
    private $parent;

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

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

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

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

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

    public function getJoiningDate(): ?\DateTimeInterface
    {
        return $this->joining_date;
    }

    public function setJoiningDate(\DateTimeInterface $joining_date): self
    {
        $this->joining_date = $joining_date;

        return $this;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(int $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getTeacherRate(): ?string
    {
        return $this->teacher_rate;
    }

    public function setTeacherRate(?string $teacher_rate): self
    {
        $this->teacher_rate = $teacher_rate;

        return $this;
    }

    public function getTeacherRemark(): ?string
    {
        return $this->teacher_remark;
    }

    public function setTeacherRemark(?string $teacher_remark): self
    {
        $this->teacher_remark = $teacher_remark;

        return $this;
    }

    public function getParentRemark(): ?string
    {
        return $this->parent_remark;
    }

    public function setParentRemark(?string $parent_remark): self
    {
        $this->parent_remark = $parent_remark;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getStudentRate(): ?string
    {
        return $this->student_rate;
    }

    public function setStudentRate(?string $student_rate): self
    {
        $this->student_rate = $student_rate;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

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

    public function getClassType(): ?string
    {
        return $this->class_type;
    }

    public function setClassType(?string $class_type): self
    {
        $this->class_type = $class_type;

        return $this;
    }

    public function getParent(): ?ParentAccount
    {
        return $this->parent;
    }

    public function setParent(?ParentAccount $parent): self
    {
        $this->parent = $parent;

        return $this;
    }
}
