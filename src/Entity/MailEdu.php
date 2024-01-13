<?php

namespace App\Entity;

use App\Repository\MailEduRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MailEduRepository::class)]
class MailEdu extends Mail
{
    #[ORM\ManyToMany(targetEntity: Educateur::class, inversedBy: 'mailEdus')]
    private Collection $educateurs;

    public function __construct()
    {
        $this->educateurs = new ArrayCollection();
    }

    /**
     * @return Collection<int, Educateur>
     */
    public function getEducateurs(): Collection
    {
        return $this->educateurs;
    }

    public function addEducateur(Educateur $educateur): static
    {
        if (!$this->educateurs->contains($educateur)) {
            $this->educateurs->add($educateur);
        }

        return $this;
    }

    public function removeEducateur(Educateur $educateur): static
    {
        $this->educateurs->removeElement($educateur);

        return $this;
    }
}
