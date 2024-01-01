<?php

class DataHubModel {
    public int $numeroLicence;
    public string $nom;
    public string $prenom;
    public string $nomContact;
    public string $prenomContact;
    public string $emailContact;
    public string $telephoneContact;
    public string $codeCategorie;
    public string $nomCategorie;

    public function __construct(
        int $numeroLicence,
        string $nom,
        string $prenom,
        string $nomContact,
        string $prenomContact,
        string $emailContact,
        string $telephoneContact,
        string $codeCategorie,
        string $nomCategorie
    ) {
        $this->numeroLicence = $numeroLicence;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->nomContact = $nomContact;
        $this->prenomContact = $prenomContact;
        $this->emailContact = $emailContact;
        $this->telephoneContact = $telephoneContact;
        $this->codeCategorie = $codeCategorie;
        $this->nomCategorie = $nomCategorie;
    }

    // Ajoutez les getters et setters appropriés ici


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
     * Get the value of nomContact
     *
     * @return string
     */
    public function getNomContact(): string
    {
        return $this->nomContact;
    }

    /**
     * Set the value of nomContact
     *
     * @param string $nomContact
     *
     * @return self
     */
    public function setNomContact(string $nomContact): self
    {
        $this->nomContact = $nomContact;

        return $this;
    }

    /**
     * Get the value of emailContact
     *
     * @return string
     */
    public function getEmailContact(): string
    {
        return $this->emailContact;
    }

    /**
     * Set the value of emailContact
     *
     * @param string $emailContact
     *
     * @return self
     */
    public function setEmailContact(string $emailContact): self
    {
        $this->emailContact = $emailContact;

        return $this;
    }

    /**
     * Get the value of telephoneContact
     *
     * @return string
     */
    public function getTelephoneContact(): string
    {
        return $this->telephoneContact;
    }

    /**
     * Set the value of telephoneContact
     *
     * @param string $telephoneContact
     *
     * @return self
     */
    public function setTelephoneContact(string $telephoneContact): self
    {
        $this->telephoneContact = $telephoneContact;

        return $this;
    }

    /**
     * Get the value of codeCategorie
     */
    public function getCodeCategorie(): string
    {
        return $this->codeCategorie;
    }

    /**
     * Set the value of codeCategorie
     */
    public function setCodeCategorie(string $codeCategorie): self
    {
        $this->codeCategorie = $codeCategorie;

        return $this;
    }

    /**
     * Get the value of nomCategorie
     *
     * @return string
     */
    public function getNomCategorie(): string
    {
        return $this->nomCategorie;
    }

    /**
     * Set the value of nomCategorie
     *
     * @param string $nomCategorie
     *
     * @return self
     */
    public function setNomCategorie(string $nomCategorie): self
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }
}
?>
