<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SalaryPackage
 *
 * @ORM\Table(name="salary_package")
 * @ORM\Entity
 */
class SalaryPackage
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
     * @ORM\Column(name="salary", type="string", length=100, nullable=false)
     */
    private $salary;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSalary(): ?string
    {
        return $this->salary;
    }

    public function setSalary(string $salary): self
    {
        $this->salary = $salary;

        return $this;
    }


}
