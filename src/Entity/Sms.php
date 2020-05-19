<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SmsRepository")
 */
class Sms
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
    private $service_name;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $service_number;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $device_id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $sms_user;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $sms_pass;

    /**
     * @ORM\Column(type="boolean")
     */
    private $service_status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceName(): ?string
    {
        return $this->service_name;
    }

    public function setServiceName(string $service_name): self
    {
        $this->service_name = $service_name;

        return $this;
    }

    public function getServiceNumber(): ?string
    {
        return $this->service_number;
    }

    public function setServiceNumber(?string $service_number): self
    {
        $this->service_number = $service_number;

        return $this;
    }

    public function getDeviceId(): ?int
    {
        return $this->device_id;
    }

    public function setDeviceId(?int $device_id): self
    {
        $this->device_id = $device_id;

        return $this;
    }

    public function getSmsUser(): ?string
    {
        return $this->sms_user;
    }

    public function setSmsUser(?string $sms_user): self
    {
        $this->sms_user = $sms_user;

        return $this;
    }

    public function getSmsPass(): ?string
    {
        return $this->sms_pass;
    }

    public function setSmsPass(?string $sms_pass): self
    {
        $this->sms_pass = $sms_pass;

        return $this;
    }

    public function getServiceStatus(): ?bool
    {
        return $this->service_status;
    }

    public function setServiceStatus(bool $service_status): self
    {
        $this->service_status = $service_status;

        return $this;
    }

}
