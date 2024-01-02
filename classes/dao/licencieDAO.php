<?php
require_once("../classes/dao/DaoInterface.php");
require_once("../classes/dao/CategorieDAO.php");
require_once("../classes/dao/ContactDAO.php");

class LicencieDAO implements DaoInterface {
    private $connexion;
    private CategorieDAO  $categorieDAO;
    private ContactDAO $contactDAO;

    public function __construct(Connexion $connexion,CategorieDAO $categorieDAO, ContactDAO $contactDAO) {
        $this->connexion = $connexion;
        $this->categorieDAO= $categorieDAO;
        $this->contactDAO = $contactDAO;
    }

    /**
 * Vérifier si le numéro de licence existe déjà
 *
 * @param int $numeroLicence
 * @return bool
 */


 public function isNumeroLicenceExists($numeroLicence) {
    try {
        $stmt = $this->connexion->pdo->prepare("SELECT COUNT(*) FROM licencie WHERE numeroLicence = ?");
        $stmt->execute([$numeroLicence]);
        $count = $stmt->fetchColumn();

        return $count > 0; // Si le compte est supérieur à zéro, le numéro de licence existe déjà
    } catch (PDOException $e) {
        // 
        return false;
    }
}


public function getLicencieByNumeroLicence($numeroLicence)
{
    try {
        $stmt = $this->connexion->pdo->prepare("SELECT * FROM licencie WHERE numeroLicence = ?");
        $stmt->execute([$numeroLicence]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            
            $licencie = new LicencieModel();
            $licencie->setNumeroLicence($row['numeroLicence']);
            $licencie->setNom($row['nom']);
            $licencie->setPrenom($row['prenom']);

            // récupérer le contact et la catégorie associés
            $licencie->setContact($this->contactDAO->getContact($row['idcontact']));
            $licencie->setCategorie($this->categorieDAO->getCategorie($row['idcategorie']));

            return $licencie;
        } else {
            return null;
        }
    } catch (PDOException $e) {
       
        return null;
    }
}


    // Ajouter un licencie
    public function create($licencie) {
       
        
        if($licencie instanceof LicencieModel){
  
        try {

            // Vérifier si le numéro de licence existe déjà
            if ($this->isNumeroLicenceExists($licencie->getNumeroLicence())) {
            
                echo "Erreur: Numéro de licence déjà existant.";
                return false;
            }
    // Vérifier si le code de la catégorie existe déjà
    $existingCategorie = $this->categorieDAO->getCategorie($licencie->getCategorie()->getCode());
    var_dump($existingCategorie);
    if ($existingCategorie) {
        // La catégorie avec le code spécifié existe déjà, on l'utilise pour créer le licencie
        $licencie->setCategorie($existingCategorie);
    } else {
        // La catégorie n'existe pas, on la créé d'abord
        $this->categorieDAO->create($licencie->getCategorie());
        $licencie->setCategorie($this->categorieDAO->getCategorie($licencie->getCategorie()->getCode()));
    }

         // Vérifier si l'ID du contact existe déjà
         $existingContact = $this->contactDAO->getContact(
            $licencie->getContact()->getId()
           
        );
        var_dump($existingContact);

        if ($existingContact) {
            $licencie->setContact($existingContact);
        } else {
            // Sinon, créez le contact
            $this->contactDAO->create($licencie->getContact());
            // Récupérez le contact fraîchement créé
            $licencie->setContact($this->contactDAO->getContact(
                $licencie->getContact()->getNom(),
                $licencie->getContact()->getPrenom(),
                $licencie->getContact()->getEmail(),
                $licencie->getContact()->getTelephone()
            ));
        }
            $stmt = $this->connexion->pdo->prepare("INSERT INTO licencie(numeroLicence,nom,prenom,idcontact,idcategorie,email,pwd,isAdmin) VALUES (?, ?,?,?,?,?,?,?)");
            $stmt->execute([$licencie->getNumeroLicence(), $licencie->getNom(),$licencie->getPrenom(),$licencie->getContact()->getId(),$licencie->getCategorie()->getCode(),null,null,null]);
            
            return true;
        } catch (PDOException $e) {
            return false;
        }
    } else {
        echo "ecehec enregistrement";
    }
    }

  // Modifier un licencie
    public function modify ($licencie){
        if($licencie instanceof LicencieModel){
        try {
            $stmt = $this->connexion->pdo->prepare("UPDATE licencie SET nom = ?,prenom = ?,idcontact = ?,idcategorie = ?,email=?,pwd=?,isAdmin=? WHERE numeroLicence = ?");
            $stmt->execute([$licencie->getNom(), $licencie->getPrenom(),$licencie->getContact()->getId(),$licencie->getCategorie()->getCode(),null,null,null,$licencie->getNumeroLicence()]);
            return true;
        } catch (PDOException $e) {
            
            return false;
        }
    }

    }

    // Supprimer un licencie
    public function delete($numeroLicence) {
        try {
            $stmt = $this->connexion->pdo->prepare("DELETE FROM licencie WHERE numeroLicence = ?");
            $stmt->execute([$numeroLicence]);
            return true;
        } catch (PDOException $e) {
            
            return false;
        }
    }


   // Supprimer le contact du licencié en mettant le champ à null
    public function deleteContactForLicencie($numeroLicence)
{
    try {
        
        $stmt = $this->connexion->pdo->prepare("UPDATE licencie SET idcontact = null WHERE numeroLicence = ?");
        $stmt->execute([$numeroLicence]);

        return true;
    } catch (PDOException $e) {
        
        return false;
    }
}

  // La liste des licencies
    public function list() {
        try {
            $stmt = $this->connexion->pdo->prepare("SELECT * FROM licencie");
            $stmt->execute();
            $licencies = $stmt->fetchAll(PDO::FETCH_CLASS, 'LicencieModel');

            foreach ($licencies as $licencie) {
                $stmt0 = $this->connexion->pdo->prepare("SELECT idcategorie, idcontact FROM licencie WHERE numeroLicence = ?");
                $stmt0->execute([$licencie->getNumeroLicence()]);
                $result = $stmt0->fetchAll(PDO::FETCH_ASSOC)[0];
                $licencie->setCategorie($this->categorieDAO->getCategorie($result['idcategorie']));
                $licencie->setContact($this->contactDAO->getContact($result['idcontact']));

            }
    
            return $licencies;
        } catch (PDOException $e) {
            return false;
        }
    }
    

  
}
?>
