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
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=AdminUser::class, inversedBy="shifts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adminUser;

    /**
     * @ORM\ManyToOne(targetEntity=Positions::class, inversedBy="position")
     */
    private $positions;

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

    public function getAdminUser(): ?AdminUser
    {
        return $this->adminUser;
    }

    public function setAdminUser(?AdminUser $adminUser): self
    {
        $this->adminUser = $adminUser;

        return $this;
    }

    public function getPositions(): ?Positions
    {
        return $this->positions;
    }

    public function setPositions(?Positions $positions): self
    {
        $this->positions = $positions;

        return $this;
    }
}
