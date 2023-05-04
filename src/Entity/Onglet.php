<?php

namespace App\Entity;

use App\Repository\OngletRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OngletRepository::class)]
class Onglet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $Title_onglet = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $img = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $Liens = null;

    #[ORM\ManyToOne(inversedBy: 'ongletId')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleOnglet(): ?string
    {
        return $this->Title_onglet;
    }

    public function setTitleOnglet(string $Title_onglet): self
    {
        $this->Title_onglet = $Title_onglet;

        return $this;
    }

    public function getImg()
    {
        return $this->img;
    }

    public function setImg($img): self
    {
        $this->img = $img;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLiens(): ?string
    {
        return $this->Liens;
    }

    public function setLiens(string $Liens): self
    {
        $this->Liens = $Liens;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
