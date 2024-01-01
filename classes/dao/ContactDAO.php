<?php
require_once("../classes/dao/DaoInterface.php");
class ContactDAO implements DaoInterface {
    private $connexion;

    public function __construct(Connexion $connexion) {
        $this->connexion = $connexion;
    }



    public function getContact(String $nom, String $prenom, String $email, String $telephone): ?ContactModel
{
    try {
        $stmt = $this->connexion->pdo->prepare("SELECT * FROM contact WHERE nom = ? AND prenom = ? AND email = ? AND telephone = ?");
        $stmt->execute([$nom, $prenom, $email, $telephone]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $contact = new ContactModel();
            $contact->setId($row['id']);
            $contact->setNom($row['nom']);
            $contact->setPrenom($row['prenom']);
            $contact->setEmail($row['email']);
            $contact->setTelephone($row['telephone']);

            return $contact;
        } else {
            // Retourner null si aucun contact n'est trouvé
            return null;
        }
    } catch (PDOException $e) {
        // Gérer les erreurs de récupération ici
        return null;
    }
}

public function getContactById($id)
{
    try {
        $stmt = $this->connexion->pdo->prepare("SELECT * FROM contact WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $contact = new ContactModel();
            $contact->setId($row['id']);
            $contact->setNom($row['nom']);
            $contact->setPrenom($row['prenom']);
            $contact->setEmail($row['email']);
            $contact->setTelephone($row['telephone']);

            return $contact;
        } else {
            return null;
        }
    } catch (PDOException $e) {
        // Gérer les erreurs de récupération ici
        return null;
    }
}



public function isContactExists($nom, $prenom, $email, $telephone) {
    try {
        $stmt = $this->connexion->pdo->prepare("SELECT COUNT(*) as count FROM contact WHERE nom = ? AND prenom = ? AND email = ? AND telephone = ?");
        $stmt->execute([$nom, $prenom, $email, $telephone]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si le contact existe déjà, retourne true
        return ($result['count'] > 0);
    } catch (PDOException $e) {
        // Gérer les erreurs de vérification ici
        return false;
    }
}


    public function create($contact) {
       
        if($contact instanceof ContactModel){
          
        try {

             // Vérifier si le contact existe déjà
             if ($this->isContactExists($contact->getNom(),$contact->getPrenom(),$contact->getEmail(),$contact->getTelephone(),)) {
                
                echo "Erreur: Code de catégorie déjà existant.";
                return false;
            }
           
            $stmt = $this->connexion->pdo->prepare("INSERT INTO contact(nom,prenom,email,telephone) VALUES (?, ?,?,?)");
            $stmt->execute([$contact->getNom(), $contact->getPrenom(),$contact->getEmail(),$contact->getTelephone()]);
            
            return true;
        } catch (PDOException $e) {
            // GÃ©rer les erreurs d'insertion ici
            return false;
        }
    } else {
        echo "ecehec enregistrement";
    }
    }

    public function modify ($contact){
        if($contact instanceof ContactModel){
        try {
            $stmt = $this->connexion->pdo->prepare("UPDATE contact SET nom = ?, prenom = ? , email= ?, telephone = ? WHERE id = ?");
            $stmt->execute([$contact->getNom(), $contact->getPrenom(),$contact->getEmail(),$contact->getTelephone(), $contact->getId()]);
            return true;
        } catch (PDOException $e) {
            // GÃ©rer les erreurs de mise Ã  jour ici
            return false;
        }
    }

    }
    

    public function delete($id) {
        try {
            $stmt = $this->connexion->pdo->prepare("DELETE FROM contact WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            // Afficher le message d'erreur pour le débogage
            echo "Erreur lors de la suppression : " . $e->getMessage();
            // Gérer les erreurs de suppression ici
            return false;
        }
    }
    
    public function list() {
        try {
            $stmt = $this->connexion->pdo->prepare("SELECT * FROM contact");
            $stmt->execute();
    
            // Récupérer toutes les lignes résultantes en tant qu'objets CategorieModel
            $contacts = $stmt->fetchAll(PDO::FETCH_CLASS, 'ContactModel');
    
            return $contacts;
        } catch (PDOException $e) {
            // Gérer les erreurs de récupération de données ici
            return false;
        }
    }
    


}
?>
