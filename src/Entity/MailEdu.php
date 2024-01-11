<?php

namespace App\Entity;

use App\Repository\MailEduRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MailEduRepository::class)]


class MailEdu extends Mail
{

    #[ORM\OneToMany(mappedBy: 'mailEdu', targetEntity: Educateur::class)]
    private Collection $educateurs;

    public function __construct()
    {
        $this->educateurs = new ArrayCollection();
    }



    /**
     * @return Collection<int, educateur>
     */
    public function getEducateurs(): Collection
    {
        return $this->educateurs;
    }

    public function addEducateur(Educateur $educateur): static
    {
        if (!$this->educateurs->contains($educateur)) {
            $this->educateurs->add($educateur);
            $educateur->setMailEdu($this);
        }

        return $this;
    }

    public function removeEducateur(Educateur $educateur): static
    {
        if ($this->educateurs->removeElement($educateur)) {
            // set the owning side to null (unless already changed)
            if ($educateur->getMailEdu() === $this) {
                $educateur->setMailEdu(null);
            }
        }

        return $this;
    }

}
