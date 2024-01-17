<?php
require_once("../classes/dao/DaoInterface.php");
require_once("../classes/dao/CategorieDAO.php");
require_once("../classes/dao/ContactDAO.php");

class EducateurDAO implements DaoInterface {
    private $connexion;
    private CategorieDAO  $categorieDAO;
    private ContactDAO $contactDAO;

    public function __construct(Connexion $connexion,CategorieDAO $categorieDAO, ContactDAO $contactDAO) {
        $this->connexion = $connexion;
        $this->categorieDAO= $categorieDAO;
        $this->contactDAO = $contactDAO;
    }


    public function isNumeroLicenceExists($numeroLicence) {
        try {
            $stmt = $this->connexion->pdo->prepare("SELECT COUNT(*) FROM licencie WHERE numeroLicence = ?");
            $stmt->execute([$numeroLicence]);
            $count = $stmt->fetchColumn();
    
            return $count > 0; // Si le compte est supérieur à zéro, le numéro de licence existe déjà
        } catch (PDOException $e) {
            
            return false;
        }
    }



    public function getEducateurById($numeroLicence) {
        try {
            $stmt = $this->connexion->pdo->prepare("SELECT * FROM licencie WHERE numeroLicence = ?");
            $stmt->execute([$numeroLicence]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                // Créez un objet EducateurModel à partir des données de la base de données
                $educateur = new EducateurModel();
                $educateur->setNumeroLicence($row['numeroLicence']);
                $educateur->setNom($row['nom']);
                $educateur->setPrenom($row['prenom']);
                $educateur->setEmail($row['email']);
                $educateur->setPwd($row['pwd']); 
                $educateur->setIsAdmin($row['isAdmin']);
               // récupérer le contact et la catégorie associés
            $educateur->setContact($this->contactDAO->getContact($row['idcontact']));
            $educateur->setCategorie($this->categorieDAO->getCategorie($row['idcategorie']));

                

                return $educateur;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            
            return null;
        }
    }

    
    public function create($educateur) {
       
        
        if($educateur instanceof EducateurModel){
  
        try {

            // Vérifier si le numéro de licence existe déjà
            if ($this->isNumeroLicenceExists($educateur->getNumeroLicence())) {
                $this->modify($educateur);
                echo "Erreur: Numéro de licence déjà existant.";
                return true;
            }

            

    // Vérifier si le code de la catégorie existe déjà
    $existingCategorie = $this->categorieDAO->getCategorie($educateur->getCategorie()->getCode());
    if ($existingCategorie) {
        
        $educateur->setCategorie($existingCategorie);
    } else {
        
        $this->categorieDAO->create($educateur->getCategorie());
        $educateur->setCategorie($this->categorieDAO->getCategorie($educateur->getCategorie()->getCode()));
    }

         // Vérifier si l'ID du contact existe déjà
         $existingContact = $this->contactDAO->getContact(
            $educateur->getContact()->getId()
        
        );

        if ($existingContact) {
            $educateur->setContact($existingContact);
        } else {
            // Sinon, créez le contact
            $this->contactDAO->create($educateur->getContact());
            // Récupérez le contact fraîchement créé
            $educateur->setContact($this->contactDAO->getContact(
                $educateur->getContact()->getNom(),
                $educateur->getContact()->getPrenom(),
                $educateur->getContact()->getEmail(),
                $educateur->getContact()->getTelephone()
            ));
        }

$hashedPassword = password_hash($educateur->getPwd(), PASSWORD_DEFAULT);

$stmt = $this->connexion->pdo->prepare("INSERT INTO licencie(numeroLicence, nom, prenom, idcontact, idcategorie, email, pwd, isAdmin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([
    $educateur->getNumeroLicence(),
    $educateur->getNom(),
    $educateur->getPrenom(),
    $educateur->getContact()->getId(),
    $educateur->getCategorie()->getCode(),
    $educateur->getEmail(),
    $hashedPassword,  
    $educateur->getIsAdmin()
]);

            return true;
        } catch (PDOException $e) {
           
            return false;
        }
    } else {
        echo "ecehec enregistrement";
    }
    }

    public function modify($educateur) {

       // var_dump( $educateur->getContact()->getId());
       // var_dump($educateur->getCategorie()->getCode());
        if ($educateur instanceof EducateurModel) {
            try {
                // Vérifiez si un nouveau mot de passe a été fourni
               // $hashedPassword = !empty($educateur->getPwd()) ? password_hash($educateur->getPwd(), PASSWORD_DEFAULT) : null;
    
                $stmt = $this->connexion->pdo->prepare("UPDATE licencie SET nom = ?, prenom =?,idContact=?,idCategorie=?,email = ?,isAdmin=? WHERE numeroLicence = ?");
                $stmt->execute([
                    $educateur->getNom(),
                    $educateur->getPrenom(),
                    $educateur->getContact()?->getId(),
                    $educateur->getCategorie()->getCode(),
                    $educateur->getEmail(),
                //    // $hashedPassword,
                    $educateur->getIsAdmin(),
                    
                   
                    $educateur->getNumeroLicence()
                    
                ]);

                
            } catch (PDOException $e) {
                // Gérer les erreurs de mise à jour ici
                return false;
            }
        }
        return true;
    }
    
    public function delete($numeroLicence) {
        try {
            $stmt = $this->connexion->pdo->prepare("DELETE FROM licencie WHERE numeroLicence = ?");
            $stmt->execute([$numeroLicence]);
            return true;
        } catch (PDOException $e) {
            // Gérer les erreurs de suppression ici
            return false;
        }
    }
    
    public function list()
    {
        try {
            $stmt = $this->connexion->pdo->prepare("SELECT * FROM licencie WHERE email IS NOT NULL AND pwd IS NOT NULL AND isAdmin IS NOT NULL");
            $stmt->execute();

            // Récupérer toutes les lignes résultantes en tant qu'objets EducateurModel
            $educateurs = $stmt->fetchAll(PDO::FETCH_CLASS, 'EducateurModel');

            foreach ($educateurs as $educateur) {
                $stmt0 = $this->connexion->pdo->prepare("SELECT idcategorie, idcontact FROM licencie WHERE numeroLicence = ?");
                $stmt0->execute([$educateur->getNumeroLicence()]);
                $result = $stmt0->fetchAll(PDO::FETCH_ASSOC)[0];
                $educateur->setCategorie($this->categorieDAO->getCategorie($result['idcategorie']));
                $educateur->setContact($this->contactDAO->getContact($result['idcontact']));

            }

            return $educateurs;
        } catch (PDOException $e) {
            
            return false;
        }
    }

    

 
}
?>
