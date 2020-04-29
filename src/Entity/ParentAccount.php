<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ParentAccount
 *
 * @ORM\Table(name="parent_account")
 * @ORM\Entity
 */
class ParentAccount
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
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

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
     * @ORM\Column(name="fee", type="string", length=20, nullable=true)
     */
    private $fee;

    /**
     * @var int|null
     *
     * @ORM\Column(name="active", type="integer", nullable=true)
     */
    private $active;

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
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updatedAt = 'CURRENT_TIMESTAMP';

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

    public function getFee(): ?string
    {
        return $this->fee;
    }

    public function setFee(?string $fee): self
    {
        $this->fee = $fee;

        return $this;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(?int $active): self
    {
        $this->active = $active;

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


}
