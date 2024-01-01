<?php

class DatahubDAO  {
    private $connexion;

    public function __construct(Connexion $connexion) {
        $this->connexion = $connexion;
    }


    public function insertCsvData($fichier)
    {
        try {
            $sqlrech = " 
            LOAD DATA  INFILE '".$fichier."' INTO TABLE datahub
            FIELDS TERMINATED BY ',' 
            OPTIONAlLY ENCLOSED BY '\"' 
            ESCAPED BY '\\\\'
            LINES TERMINATED BY '\\r\\n'
            IGNORE 1 LINES
            (numeroLicence,nom,prenom,nomContact,prenomContact,
            emailContact,telephoneContact, codeCategorie,nomCategorie); ";
            $stmt = $this->connexion->pdo->prepare($sqlrech);
            
        
            $stmt->execute();
        
            
            //exit;
        } catch (Exception $e) {
            $stmt = null;
            $res = null;
            var_dump($e->getMessage());
        }
        return 1;
    }

   


}
?>
