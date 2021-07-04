<?php

namespace App\Entity;

use App\Repository\ShiftsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShiftsRepository::class)
 */
class Shifts
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AdminUser", inversedBy="shifts")
     */
    private $adminuser;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Positions", inversedBy="shifts")
     */
    private $positions;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
