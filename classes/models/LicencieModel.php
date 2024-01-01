<?php

class LicencieModel {

    protected int  $numeroLicence;
    protected string $nom;
    protected string $prenom;
    protected ContactModel $contact;
    protected CategorieModel $categorie;


    /**
     * Get the value of numeroLicence
     *
     * @return int
     */
    public function getNumeroLicence(): int
    {
        return $this->numeroLicence;
    }

    /**
     * Get the value of nom
     *
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @param string $nom
     *
     * @return self
     */
    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of prenom
     *
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @param string $prenom
     *
     * @return self
     */
    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get the value of contact
     *
     * @return ContactModel
     */
    public function getContact(): ContactModel
    {
        return $this->contact;
    }

    /**
     * Set the value of contact
     *
     * @param ContactModel $contact
     *
     * @return self
     */
    public function setContact(ContactModel $contact): self
    {
        $this->contact = $contact;

        return $this;
    }


    /**
     * Set the value of numeroLicence
     *
     * @param int $numeroLicence
     *
     * @return self
     */
    public function setNumeroLicence(int $numeroLicence): self
    {
        $this->numeroLicence = $numeroLicence;

        return $this;
    }

    /**
     * Get the value of categorie
     *
     * @return CategorieModel
     */
    public function getCategorie(): CategorieModel
    {
        return $this->categorie;
    }

    /**
     * Set the value of categorie
     *
     * @param CategorieModel $categorie
     *
     * @return self
     */
    public function setCategorie(CategorieModel $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }


    
}
?>

