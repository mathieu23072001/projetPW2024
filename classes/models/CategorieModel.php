<?php

class CategorieModel {

    private string  $code="";
    private string $nom = "";

    /**
     * Get the value of code
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }


    /**
     * Set the value of code
     *
     * @param string $code
     *
     * @return self
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

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


    
}

?>

