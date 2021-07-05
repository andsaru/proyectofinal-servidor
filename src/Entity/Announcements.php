<?php

namespace App\Entity;

use App\Repository\AnnouncementsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnouncementsRepository::class)
 */
class Announcements
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
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=5000)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=AdminUser::class, inversedBy="announcements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adminUser;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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
}
