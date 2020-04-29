<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employee
 *
 * @ORM\Table(name="employee", indexes={@ORM\Index(name="IDX_B0F6A6D5E03A62C5", columns={"salary_package_id"})})
 * @ORM\Entity
 */
class Employee
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="father_name", type="string", length=255, nullable=true)
     */
    private $fatherName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="cnic", type="string", length=30, nullable=true)
     */
    private $cnic;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="text", length=0, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mobile", type="string", length=20, nullable=true)
     */
    private $mobile;

    /**
     * @var string|null
     *
     * @ORM\Column(name="telephone", type="string", length=20, nullable=true)
     */
    private $telephone;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    private $birthday;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nationality", type="string", length=30, nullable=true)
     */
    private $nationality;

    /**
     * @var string|null
     *
     * @ORM\Column(name="skype", type="string", length=30, nullable=true)
     */
    private $skype;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=100, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100, nullable=false)
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="qualification1", type="string", length=255, nullable=true)
     */
    private $qualification1;

    /**
     * @var string|null
     *
     * @ORM\Column(name="qualification2", type="string", length=255, nullable=true)
     */
    private $qualification2;

    /**
     * @var string|null
     *
     * @ORM\Column(name="qualification3", type="string", length=255, nullable=true)
     */
    private $qualification3;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updatedAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \SalaryPackage
     *
     * @ORM\ManyToOne(targetEntity="SalaryPackage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="salary_package_id", referencedColumnName="id")
     * })
     */
    private $salaryPackage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EmployeeCategory")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

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

    public function getFatherName(): ?string
    {
        return $this->fatherName;
    }

    public function setFatherName(?string $fatherName): self
    {
        $this->fatherName = $fatherName;

        return $this;
    }

    public function getCnic(): ?string
    {
        return $this->cnic;
    }

    public function setCnic(?string $cnic): self
    {
        $this->cnic = $cnic;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

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

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): self
    {
        $this->mobile = $mobile;

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

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(?string $nationality): self
    {
        $this->nationality = $nationality;

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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getQualification1(): ?string
    {
        return $this->qualification1;
    }

    public function setQualification1(?string $qualification1): self
    {
        $this->qualification1 = $qualification1;

        return $this;
    }

    public function getQualification2(): ?string
    {
        return $this->qualification2;
    }

    public function setQualification2(?string $qualification2): self
    {
        $this->qualification2 = $qualification2;

        return $this;
    }

    public function getQualification3(): ?string
    {
        return $this->qualification3;
    }

    public function setQualification3(?string $qualification3): self
    {
        $this->qualification3 = $qualification3;

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

    public function getSalaryPackage(): ?SalaryPackage
    {
        return $this->salaryPackage;
    }

    public function setSalaryPackage(?SalaryPackage $salaryPackage): self
    {
        $this->salaryPackage = $salaryPackage;

        return $this;
    }

    public function getCategory(): ?EmployeeCategory
    {
        return $this->category;
    }

    public function setCategory(?EmployeeCategory $category): self
    {
        $this->category = $category;

        return $this;
    }


}
