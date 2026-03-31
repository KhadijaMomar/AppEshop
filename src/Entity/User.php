<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40)]
    private ?string $name = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(length: 20)]
    private ?string $phone = null;

    // Email obligatoire et unique
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    // Mot de passe hashé
    #[ORM\Column]
    private ?string $password = null;

    // Rôles JSON
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    // 👉 Date de naissance (nullable)
    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $birthDate = null;

    /**
     * @var Collection<int, CustomerAddress>
     */
    #[ORM\OneToMany(targetEntity: CustomerAddress::class, mappedBy: 'user')]
    private Collection $customerAddresses;

    public function __construct()
    {
        $this->customerAddresses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
       
        $this->phone = preg_replace('/\D/', '', $phone);

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    // 🔐 Identifier pour Symfony (login)
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    // 🔐 Rôles utilisateur
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    // 🔐 Mot de passe hashé
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }
    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    // 🔐 Nettoyage des infos sensibles (inutile ici)
    public function eraseCredentials(): void
    {
    }

    /**
     * @return Collection<int, CustomerAddress>
     */
    public function getCustomerAddresses(): Collection
    {
        return $this->customerAddresses;
    }

    public function addCustomerAddress(CustomerAddress $customerAddress): static
    {
        if (!$this->customerAddresses->contains($customerAddress)) {
            $this->customerAddresses->add($customerAddress);
            $customerAddress->setUser($this);
        }
        return $this;
    }

    public function removeCustomerAddress(CustomerAddress $customerAddress): static
    {
        if ($this->customerAddresses->removeElement($customerAddress)) {
            if ($customerAddress->getUser() === $this) {
                $customerAddress->setUser(null);
            }
        }
        return $this;
    }
}