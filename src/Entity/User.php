<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
//use Doctrine\ORM\Mapping\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use DateTimeInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[UniqueEntity(fields: ['pseudo'], message: 'Un compte existe déjà avec ce pseudo')]
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $pseudo = null;

    /**
     * @ORM\Column(type="text")
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;


    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column]
    private ?int $code_postal = null;

    #[ORM\Column(length: 100)]
    private ?string $lastName = null;

    #[ORM\Column(length: 100)]
    private ?string $firstName = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Onglet::class)]
    private Collection $ongletId; 

    #[ORM\Column]
    private ?\DateTimeImmutable $CreatedAt = null;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: CssModifer::class)]
    private Collection $cssModiferId;

    #[ORM\OneToMany(mappedBy: 'userId', targetEntity: PageProject::class)]
    private Collection $pageProjects;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    private $imagePath;

    public function __construct()
    {
        $this->ongletId = new ArrayCollection();
        $this->cssModiferId = new ArrayCollection();
        $this->pageProjects = new ArrayCollection();
    }

    /**
    * @ORM\PrePersist
    */
    public function prePersist(): void
    {
        $this->CreatedAt = new \DateTimeImmutable();
    }

    /**
     * @ORM\PrePersist
     */
    public function createOngletForUser()
    {
        $onglet = new Onglet();
        $onglet->setUser($this);
        $this->addOnglet($onglet);
    }

    #[Assert\IsTrue(message: 'The password cannot match your first name')]
    public function isPasswordSafe()
    {
        // ... return true or falsez
         return $this->firstName !== $this->password;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->pseudo;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_MEMBRE';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    public function setCodePostal(int $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return Collection<int, onglet>
     */
    public function getOngletId(): Collection
    {
        return $this->ongletId;
    }

    public function addOnglet(onglet $ongletId): self
    {
        if (!$this->ongletId->contains($ongletId)) {
            $this->ongletId->add($ongletId);
            $ongletId->setUser($this);
        }

        return $this;
    }

    public function removeOngletId(onglet $ongletId): self
    {
        if ($this->ongletId->removeElement($ongletId)) {
            // set the owning side to null (unless already changed)
            if ($ongletId->getUser() === $this) {
                $ongletId->setUser(null);
            }
        }

        return $this;
    }



    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeImmutable $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    /**
     * @return Collection<int, CssModifer>
     */
    public function getCssModiferId(): Collection
    {
        return $this->cssModiferId;
    }

    public function addCssModiferId(CssModifer $cssModiferId): self
    {
        if (!$this->cssModiferId->contains($cssModiferId)) {
            $this->cssModiferId->add($cssModiferId);
            $cssModiferId->setUserId($this);
        }

        return $this;
    }

    public function removeCssModiferId(CssModifer $cssModiferId): self
    {
        if ($this->cssModiferId->removeElement($cssModiferId)) {
            // set the owning side to null (unless already changed)
            if ($cssModiferId->getUserId() === $this) {
                $cssModiferId->setUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PageProject>
     */
    public function getPageProjects(): Collection
    {
        return $this->pageProjects;
    }

    public function addPageProject(PageProject $pageProject): self
    {
        if (!$this->pageProjects->contains($pageProject)) {
            $this->pageProjects->add($pageProject);
            $pageProject->setUserId($this);
        }

        return $this;
    }

    public function removePageProject(PageProject $pageProject): self
    {
        if ($this->pageProjects->removeElement($pageProject)) {
            // set the owning side to null (unless already changed)
            if ($pageProject->getUserId() === $this) {
                $pageProject->setUserId(null);
            }
        }

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath($path)
    {
    $this->imagePath = $path;
    }


}
