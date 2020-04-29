<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TimezoneRepository")
 */
class Timezone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=101, nullable=true)
     */
    private $timezone_diff;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $php_timezone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    private $country;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimezoneDiff(): ?string
    {
        return $this->timezone_diff;
    }

    public function setTimezoneDiff(?string $timezone_diff): self
    {
        $this->timezone_diff = $timezone_diff;

        return $this;
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

    public function getPhpTimezone(): ?string
    {
        return $this->php_timezone;
    }

    public function setPhpTimezone(string $php_timezone): self
    {
        $this->php_timezone = $php_timezone;

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
}
