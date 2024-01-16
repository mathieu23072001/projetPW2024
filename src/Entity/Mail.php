<?php

namespace App\Entity;

use App\Repository\MailRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: MailRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name :"mtype", type:"string")]
#[ORM\DiscriminatorMap(["MailC" => MailContact::class, "MailE" => MailEdu::class])]
class Mail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEnvoi = null;

    #[ORM\Column(length: 255)]
    private ?string $objet = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'sendMail')]
    private ?Educateur $educateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(\DateTimeInterface $dateEnvoi): static
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    public function getObjet(): ?string
    {
        return $this->objet;
    }

    public function setObjet(string $objet): static
    {
        $this->objet = $objet;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getEducateur(): ?Educateur
    {
        return $this->educateur;
    }

    public function setEducateur(?Educateur $educateur): static
    {
        $this->educateur = $educateur;

        return $this;
    }
}
