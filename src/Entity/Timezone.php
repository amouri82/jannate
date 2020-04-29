<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Timezone
 *
 * @ORM\Table(name="timezone", indexes={@ORM\Index(name="IDX_3701B297F92F3E70", columns={"country_id"})})
 * @ORM\Entity
 */
class Timezone
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
     * @var string|null
     *
     * @ORM\Column(name="timezone_diff", type="string", length=101, nullable=true)
     */
    private $timezoneDiff;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="php_timezone", type="string", length=255, nullable=false)
     */
    private $phpTimezone;

    /**
     * @var \Country
     *
     * @ORM\ManyToOne(targetEntity="Country")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     * })
     */
    private $country;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimezoneDiff(): ?string
    {
        return $this->timezoneDiff;
    }

    public function setTimezoneDiff(?string $timezoneDiff): self
    {
        $this->timezoneDiff = $timezoneDiff;

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
        return $this->phpTimezone;
    }

    public function setPhpTimezone(string $phpTimezone): self
    {
        $this->phpTimezone = $phpTimezone;

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
