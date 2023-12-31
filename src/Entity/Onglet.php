<?php

namespace App\Entity;

use App\Repository\OngletRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity]
#[Vich\Uploadable]
class Onglet
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable:true)]  
    private ?string $imgName = null;

    #[Vich\UploadableField(mapping:"images_project", fileNameProperty:"imgName")]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'ongletId')]
    private ?User $user = null;

    #[ORM\OneToOne(mappedBy: 'ongletId', cascade: ['persist', 'remove'])]
    private ?PageProject $pageProject = null;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImgName(?string $imgName): void
    {
        $this->imgName = $imgName;
    }

    public function getImgName(): ?string
    {
        return $this->imgName;
    }

    public function getPageProject(): ?PageProject
    {
        return $this->pageProject;
    }

    public function setPageProject(?PageProject $pageProject): self
    {
        // unset the owning side of the relation if necessary
        if ($pageProject === null && $this->pageProject !== null) {
            $this->pageProject->setOngletId(null);
        }

        // set the owning side of the relation if necessary
        if ($pageProject !== null && $pageProject->getOngletId() !== $this) {
            $pageProject->setOngletId($this);
        }

        $this->pageProject = $pageProject;

        return $this;
    }

}
