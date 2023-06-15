<?php

namespace App\Entity;

use App\Repository\CssModiferRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CssModiferRepository::class)]
class CssModifer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $bgHeader = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $colorHeader = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $bgBase = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $bgBox1 = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $bgBox2 = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $bgBox3 = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $colorBase = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $colorBox1 = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $colorBox2 = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $colorBox3 = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $bgNav = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $colorNav = null;

    #[ORM\ManyToOne(inversedBy: 'cssModiferId')]
    private ?User $userId = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBgHeader(): ?string
    {
        return $this->bgHeader;
    }

    public function setBgHeader(?string $bgHeader): self
    {
        $this->bgHeader = $bgHeader;

        return $this;
    }

    public function getColorHeader(): ?string
    {
        return $this->colorHeader;
    }

    public function setColorHeader(?string $colorHeader): self
    {
        $this->colorHeader = $colorHeader;

        return $this;
    }

    public function getBgBase(): ?string
    {
        return $this->bgBase;
    }

    public function setBgBase(?string $bgBase): self
    {
        $this->bgBase = $bgBase;

        return $this;
    }

    public function getBgBox1(): ?string
    {
        return $this->bgBox1;
    }

    public function setBgBox1(?string $bgBox1): self
    {
        $this->bgBox1 = $bgBox1;

        return $this;
    }

    public function getBgBox2(): ?string
    {
        return $this->bgBox2;
    }

    public function setBgBox2(?string $bgBox2): self
    {
        $this->bgBox2 = $bgBox2;

        return $this;
    }

    public function getBgBox3(): ?string
    {
        return $this->bgBox3;
    }

    public function setBgBox3(?string $bgBox3): self
    {
        $this->bgBox3 = $bgBox3;

        return $this;
    }

    public function getColorBase(): ?string
    {
        return $this->colorBase;
    }

    public function setColorBase(?string $colorBase): self
    {
        $this->colorBase = $colorBase;

        return $this;
    }

    public function getColorBox1(): ?string
    {
        return $this->colorBox1;
    }

    public function setColorBox1(?string $colorBox1): self
    {
        $this->colorBox1 = $colorBox1;

        return $this;
    }

    public function getColorBox2(): ?string
    {
        return $this->colorBox2;
    }

    public function setColorBox2(?string $colorBox2): self
    {
        $this->colorBox2 = $colorBox2;

        return $this;
    }

    public function getColorBox3(): ?string
    {
        return $this->colorBox3;
    }

    public function setColorBox3(?string $colorBox3): self
    {
        $this->colorBox3 = $colorBox3;

        return $this;
    }

    public function getBgNav(): ?string
    {
        return $this->bgNav;
    }

    public function setBgNav(?string $bgNav): self
    {
        $this->bgNav = $bgNav;

        return $this;
    }

    public function getColorNav(): ?string
    {
        return $this->colorNav;
    }

    public function setColorNav(?string $colorNav): self
    {
        $this->colorNav = $colorNav;

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
