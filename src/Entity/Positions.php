<?php

namespace App\Entity;

use App\Repository\PositionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PositionsRepository::class)
 */
class Positions
{
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Shifts", mappedBy="positions")
     */
    private $shifts;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Shifts::class, mappedBy="positions")
     */
    private $position;

    public function __construct()
    {
        $this->position = new ArrayCollection();
    }

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

    /**
     * @return Collection|Shifts[]
     */
    public function getPosition(): Collection
    {
        return $this->position;
    }

    public function addPosition(Shifts $position): self
    {
        if (!$this->position->contains($position)) {
            $this->position[] = $position;
            $position->setPositions($this);
        }

        return $this;
    }

    public function removePosition(Shifts $position): self
    {
        if ($this->position->removeElement($position)) {
            // set the owning side to null (unless already changed)
            if ($position->getPositions() === $this) {
                $position->setPositions(null);
            }
        }

        return $this;
    }
}
