<?php

namespace App\Entity;

use App\Repository\EducateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EducateurRepository::class)]
class Educateur extends Licencie implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $pwd = null;

    #[ORM\Column]
    private ?bool $isAdmin = null;

    #[ORM\ManyToOne(inversedBy: 'educateurs')]
    private ?MailEdu $mailEdu = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPwd(): ?string
    {
        return $this->pwd;
    }

    public function setPwd(string $pwd): static
    {
        $this->pwd = $pwd;

        return $this;
    }

    public function isIsAdmin(): ?bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): static
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function getMailEdu(): ?MailEdu
    {
        return $this->mailEdu;
    }

    public function setMailEdu(?MailEdu $mailEdu): static
    {
        $this->mailEdu = $mailEdu;

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

    // Implémentation des méthodes UserInterface

    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        return $this->isAdmin ? ['ROLE_ADMIN'] : ['ROLE_USER'];
    }

    public function getPassword(): string
    {
        return $this->pwd;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials()
    {
        // Suppression des données sensibles éventuellement stockées
    }
}
