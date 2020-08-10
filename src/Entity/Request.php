<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RequestRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Request
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=12, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=8, nullable=true)
     */
    private $time;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $sent;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $origin;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $find;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $student_name1;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $student_gender1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $student_age1;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $student_name2;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $student_gender2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $student_age2;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $student_name3;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $student_gender3;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $student_age3;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $student_name4;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $student_gender4;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $student_age4;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $newsletter;

    /**
     * @var \Family
     *
     * @ORM\ManyToOne(targetEntity="Family")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     * })
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

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): self
    {
        $this->country = $country;

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

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(?string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getSent(): ?int
    {
        return $this->sent;
    }

    public function setSent(int $sent): self
    {
        $this->sent = $sent;

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

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFind(): ?string
    {
        return $this->find;
    }

    public function setFind(?string $find): self
    {
        $this->find = $find;

        return $this;
    }

    public function getStudentName1(): ?string
    {
        return $this->student_name1;
    }

    public function setStudentName1(?string $student_name1): self
    {
        $this->student_name1 = $student_name1;

        return $this;
    }

    public function getStudentGender1(): ?string
    {
        return $this->student_gender1;
    }

    public function setStudentGender1(?string $student_gender1): self
    {
        $this->student_gender1 = $student_gender1;

        return $this;
    }

    public function getStudentAge1(): ?int
    {
        return $this->student_age1;
    }

    public function setStudentAge1(?int $student_age1): self
    {
        $this->student_age1 = $student_age1;

        return $this;
    }

    public function getStudentName2(): ?string
    {
        return $this->student_name2;
    }

    public function setStudentName2(?string $student_name2): self
    {
        $this->student_name2 = $student_name2;

        return $this;
    }

    public function getStudentGender2(): ?string
    {
        return $this->student_gender2;
    }

    public function setStudentGender2(?string $student_gender2): self
    {
        $this->student_gender2 = $student_gender2;

        return $this;
    }

    public function getStudentAge2(): ?int
    {
        return $this->student_age2;
    }

    public function setStudentAge2(?int $student_age2): self
    {
        $this->student_age2 = $student_age2;

        return $this;
    }

    public function getStudentName3(): ?string
    {
        return $this->student_name3;
    }

    public function setStudentName3(?string $student_name3): self
    {
        $this->student_name3 = $student_name3;

        return $this;
    }

    public function getStudentGender3(): ?string
    {
        return $this->student_gender3;
    }

    public function setStudentGender3(?string $student_gender3): self
    {
        $this->student_gender3 = $student_gender3;

        return $this;
    }

    public function getStudentAge3(): ?int
    {
        return $this->student_age3;
    }

    public function setStudentAge3(?int $student_age3): self
    {
        $this->student_age3 = $student_age3;

        return $this;
    }

    public function getStudentName4(): ?string
    {
        return $this->student_name4;
    }

    public function setStudentName4(?string $student_name4): self
    {
        $this->student_name4 = $student_name4;

        return $this;
    }

    public function getStudentGender4(): ?string
    {
        return $this->student_gender4;
    }

    public function setStudentGender4(string $student_gender4): self
    {
        $this->student_gender4 = $student_gender4;

        return $this;
    }

    public function getStudentAge4(): ?int
    {
        return $this->student_age4;
    }

    public function setStudentAge4(?int $student_age4): self
    {
        $this->student_age4 = $student_age4;

        return $this;
    }

    public function getNewsletter(): ?string
    {
        return $this->newsletter;
    }

    public function setNewsletter(?string $newsletter): self
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    public function getParent(): ?Family
    {
        return $this->parent;
    }

    public function setParent(?Family $parent): self
    {
        $this->parent = $parent;

        return $this;
    }    
}
