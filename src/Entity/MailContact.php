<?php

namespace App\Entity;

use App\Repository\MailContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MailContactRepository::class)]


class MailContact extends Mail
{

    #[ORM\OneToMany(mappedBy: 'mailContact', targetEntity: Contact::class)]
    private Collection $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    
    /**
     * @return Collection<int, contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): static
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setMailContact($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): static
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getMailContact() === $this) {
                $contact->setMailContact(null);
            }
        }

        return $this;
    }

    
   

   
}
