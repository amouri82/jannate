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

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $active;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deactivate_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $joining_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $ijaazah;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $marital_status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $institute_email;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $experience;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $qualification;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $teams;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $zoom;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $start_time1;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $end_time1;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $start_time2;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $end_time2;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $start_time3;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $end_time3;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $bank;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $branch;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $currency;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $medical;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $entertainment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $misc;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $account_title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $account_no;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2, nullable=true)
     */
    private $salary_amount;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $eobi;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $whatsup_group;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $hour_rate;

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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getDeactivateAt(): ?\DateTimeInterface
    {
        return $this->deactivate_at;
    }

    public function setDeactivateAt(\DateTimeInterface $deactivate_at): self
    {
        $this->deactivate_at = $deactivate_at;

        return $this;
    }

    public function getJoiningAt(): ?\DateTimeInterface
    {
        return $this->joining_at;
    }

    public function setJoiningAt(?\DateTimeInterface $joining_at): self
    {
        $this->joining_at = $joining_at;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getIjaazah(): ?string
    {
        return $this->ijaazah;
    }

    public function setIjaazah(?string $ijaazah): self
    {
        $this->ijaazah = $ijaazah;

        return $this;
    }

    public function getMaritalStatus(): ?string
    {
        return $this->marital_status;
    }

    public function setMaritalStatus(?string $marital_status): self
    {
        $this->marital_status = $marital_status;

        return $this;
    }

    public function getInstituteEmail(): ?string
    {
        return $this->institute_email;
    }

    public function setInstituteEmail(?string $institute_email): self
    {
        $this->institute_email = $institute_email;

        return $this;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(?string $experience): self
    {
        $this->experience = $experience;

        return $this;
    }

    public function getQualification(): ?string
    {
        return $this->qualification;
    }

    public function setQualification(?string $qualification): self
    {
        $this->qualification = $qualification;

        return $this;
    }

    public function getTeams(): ?string
    {
        return $this->teams;
    }

    public function setTeams(?string $teams): self
    {
        $this->teams = $teams;

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

    public function getZoom(): ?string
    {
        return $this->zoom;
    }

    public function setZoom(?string $zoom): self
    {
        $this->zoom = $zoom;

        return $this;
    }

    public function getStartTime1(): ?string
    {
        return $this->start_time1;
    }

    public function setStartTime1(?string $start_time1): self
    {
        $this->start_time1 = $start_time1;

        return $this;
    }

    public function getEndTime1(): ?string
    {
        return $this->end_time1;
    }

    public function setEndTime1(?string $end_time1): self
    {
        $this->end_time1 = $end_time1;

        return $this;
    }

    public function getStartTime2(): ?string
    {
        return $this->start_time2;
    }

    public function setStartTime2(?string $start_time2): self
    {
        $this->start_time2 = $start_time2;

        return $this;
    }

    public function getEndTime2(): ?string
    {
        return $this->end_time2;
    }

    public function setEndTime2(?string $end_time2): self
    {
        $this->end_time2 = $end_time2;

        return $this;
    }

    public function getStartTime3(): ?string
    {
        return $this->start_time3;
    }

    public function setStartTime3(?string $start_time3): self
    {
        $this->start_time3 = $start_time3;

        return $this;
    }

    public function getEndTime3(): ?string
    {
        return $this->end_time3;
    }

    public function setEndTime3(string $end_time3): self
    {
        $this->end_time3 = $end_time3;

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

    public function getBranch(): ?string
    {
        return $this->branch;
    }

    public function setBranch(?string $branch): self
    {
        $this->branch = $branch;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getMedical(): ?string
    {
        return $this->medical;
    }

    public function setMedical(?string $medical): self
    {
        $this->medical = $medical;

        return $this;
    }

    public function getEntertainment(): ?string
    {
        return $this->entertainment;
    }

    public function setEntertainment(?string $entertainment): self
    {
        $this->entertainment = $entertainment;

        return $this;
    }

    public function getMisc(): ?string
    {
        return $this->misc;
    }

    public function setMisc(?string $misc): self
    {
        $this->misc = $misc;

        return $this;
    }

    public function getAccountTitle(): ?string
    {
        return $this->account_title;
    }

    public function setAccountTitle(string $account_title): self
    {
        $this->account_title = $account_title;

        return $this;
    }

    public function getAccountNo(): ?string
    {
        return $this->account_no;
    }

    public function setAccountNo(?string $account_no): self
    {
        $this->account_no = $account_no;

        return $this;
    }

    public function getSalaryAmount(): ?string
    {
        return $this->salary_amount;
    }

    public function setSalaryAmount(?string $salary_amount): self
    {
        $this->salary_amount = $salary_amount;

        return $this;
    }

    public function getEobi(): ?string
    {
        return $this->eobi;
    }

    public function setEobi(?string $eobi): self
    {
        $this->eobi = $eobi;

        return $this;
    }

    public function getWhatsupGroup(): ?string
    {
        return $this->whatsup_group;
    }

    public function setWhatsupGroup(?string $whatsup_group): self
    {
        $this->whatsup_group = $whatsup_group;

        return $this;
    }

    public function getHourRate(): ?string
    {
        return $this->hour_rate;
    }

    public function setHourRate(?string $hour_rate): self
    {
        $this->hour_rate = $hour_rate;

        return $this;
    }


}
