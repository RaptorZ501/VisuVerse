<?php

namespace App\Entity;

use App\Repository\PageProjectRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageProjectRepository::class)]
class PageProject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $titleHeader = null;

    #[ORM\Column(length: 100)]
    private ?string $titleBase = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $desBox1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $desbox2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $desBox3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imgBox1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imgBox2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imgBox3 = null;

    #[ORM\OneToOne(inversedBy: 'pageProject', cascade: ['persist', 'remove'])]
    private ?Onglet $ongletId = null;

    #[ORM\ManyToOne(inversedBy: 'pageProjects')]
    private ?User $userId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitleHeader(): ?string
    {
        return $this->titleHeader;
    }

    public function setTitleHeader(string $titleHeader): self
    {
        $this->titleHeader = $titleHeader;

        return $this;
    }

    public function getTitleBase(): ?string
    {
        return $this->titleBase;
    }

    public function setTitleBase(string $titleBase): self
    {
        $this->titleBase = $titleBase;

        return $this;
    }

    public function getDesBox1(): ?string
    {
        return $this->desBox1;
    }

    public function setDesBox1(?string $desBox1): self
    {
        $this->desBox1 = $desBox1;

        return $this;
    }

    public function getDesbox2(): ?string
    {
        return $this->desbox2;
    }

    public function setDesbox2(?string $desbox2): self
    {
        $this->desbox2 = $desbox2;

        return $this;
    }

    public function getDesBox3(): ?string
    {
        return $this->desBox3;
    }

    public function setDesBox3(?string $desBox3): self
    {
        $this->desBox3 = $desBox3;

        return $this;
    }

    public function getImgBox1(): ?string
    {
        return $this->imgBox1;
    }

    public function setImgBox1(?string $imgBox1): self
    {
        $this->imgBox1 = $imgBox1;

        return $this;
    }

    public function getImgBox2(): ?string
    {
        return $this->imgBox2;
    }

    public function setImgBox2(?string $imgBox2): self
    {
        $this->imgBox2 = $imgBox2;

        return $this;
    }

    public function getImgBox3(): ?string
    {
        return $this->imgBox3;
    }

    public function setImgBox3(?string $imgBox3): self
    {
        $this->imgBox3 = $imgBox3;

        return $this;
    }

    public function getOngletId(): ?Onglet
    {
        return $this->ongletId;
    }

    public function setOngletId(?Onglet $ongletId): self
    {
        $this->ongletId = $ongletId;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }
}
