<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParentAccountRepository")
 */
class ParentAccount
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $skype;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $fee;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $active;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $trial_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $regular_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $leave_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deactivation_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $suspension_date;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $bank;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $student_bank;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;


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
        return $this->trial_date;
    }

    public function setTrialDate(?\DateTimeInterface $trial_date): self
    {
        $this->trial_date = $trial_date;

        return $this;
    }

    public function getRegularDate(): ?\DateTimeInterface
    {
        return $this->regular_date;
    }

    public function setRegularDate(?\DateTimeInterface $regular_date): self
    {
        $this->regular_date = $regular_date;

        return $this;
    }

    public function getLeaveDate(): ?\DateTimeInterface
    {
        return $this->leave_date;
    }

    public function setLeaveDate(?\DateTimeInterface $leave_date): self
    {
        $this->leave_date = $leave_date;

        return $this;
    }

    public function getDeactivationDate(): ?\DateTimeInterface
    {
        return $this->deactivation_date;
    }

    public function setDeactivationDate(?\DateTimeInterface $deactivation_date): self
    {
        $this->deactivation_date = $deactivation_date;

        return $this;
    }

    public function getSuspensionDate(): ?\DateTimeInterface
    {
        return $this->suspension_date;
    }

    public function setSuspensionDate(?\DateTimeInterface $suspension_date): self
    {
        $this->suspension_date = $suspension_date;

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
        return $this->student_bank;
    }

    public function setStudentBank(?string $student_bank): self
    {
        $this->student_bank = $student_bank;

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

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }
}
