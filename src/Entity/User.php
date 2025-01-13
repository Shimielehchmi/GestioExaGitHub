<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private ?string $password = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $username = null;

    #[ORM\Column(length: 10)]
    private ?string $locale = null;

    #[ORM\Column]
    private ?bool $is_verified = null;

    #[ORM\ManyToMany(targetEntity: Role::class, inversedBy: 'users')]
    private Collection $roles;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Enseignant::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Enseignant $enseignant = null;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Etudient::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Etudient $etudient = null;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = [];
        foreach ($this->roles as $role) {
            $roles[] = $role->getName();
        }

        return array_unique($roles);
    }


    public function addRole(Role $role): self
    {
        if (!$this->roles->contains($role)) {
            $this->roles->add($role);
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

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

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->is_verified;
    }

    public function setIsVerified(bool $is_verified): self
    {
        $this->is_verified = $is_verified;

        return $this;
    }

    public function getEnseignant(): ?Enseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(?Enseignant $enseignant): self
    {
        // Détache l'ancien enseignant
        if ($this->enseignant && $this->enseignant->getUser() === $this) {
            $this->enseignant->setUser(null);
        }

        $this->enseignant = $enseignant;

        // Met à jour la relation inverse
        if ($enseignant && $enseignant->getUser() !== $this) {
            $enseignant->setUser($this);
        }

        return $this;
    }

    public function getEtudient(): ?Etudient
    {
        return $this->etudient;
    }

    public function setEtudient(?Etudient $etudient): self
    {
        // Détache l'ancien étudiant
        if ($this->etudient && $this->etudient->getUser() === $this) {
            $this->etudient->setUser(null);
        }

        $this->etudient = $etudient;

        // Met à jour la relation inverse
        if ($etudient && $etudient->getUser() !== $this) {
            $etudient->setUser($this);
        }

        return $this;
    }
}
