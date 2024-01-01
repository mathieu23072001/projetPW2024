<?php
require_once("../classes/dao/DaoInterface.php");
class CategorieDAO implements DaoInterface {
    private $connexion;

    public function __construct(Connexion $connexion) {
        $this->connexion = $connexion;
    }

    public function getCategorie(String $nom): ?CategorieModel {
        try {
            $stmt = $this->connexion->pdo->prepare("SELECT * FROM categorie WHERE nom = ?");
            $stmt->execute([$nom]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($row) {
                $categorie = new CategorieModel();
                $categorie->setCode($row['code']);
                $categorie->setNom($row['nom']);
                return $categorie;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            // Gérer les erreurs de récupération ici
            return null;
        }
    }
    
    public function getCategorieByCode($code)
{
    try {
        $stmt = $this->connexion->pdo->prepare("SELECT * FROM categorie WHERE code = ?");
        $stmt->execute([$code]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $categorie = new CategorieModel();
                $categorie->setCode($row['code']);
                $categorie->setNom($row['nom']);
                return $categorie;
        } else {
            return null;
        }
    } catch (PDOException $e) {
        // Gérer les erreurs de récupération ici
        return null;
    }
}



    public function isCategorieExists($code) {
        try {
            $stmt = $this->connexion->pdo->prepare("SELECT COUNT(*) as count FROM categorie WHERE code = ?");
            $stmt->execute([$code]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Si le code de catégorie existe déjà, retourne true
            return ($result['count'] > 0);
        } catch (PDOException $e) {
            // Gérer les erreurs de vérification ici
            return false;
        }
    }

    
    public function create($categorie) {
       
        
        if($categorie instanceof CategorieModel){
            $pdo = $this->connexion->pdo;
           // echo "******************".$categorie->getNom();
          
        try {

             // Vérifier si le code de la catégorie existe déjà
             if ($this->isCategorieExists($categorie->getCode())) {
                // Code de catégorie déjà existant, vous pouvez gérer cela comme vous le souhaitez
                echo "Erreur: Code de catégorie déjà existant.";
                return false;
            }
    


            ///$pdo->beginTransaction();
            $stmt = $pdo->prepare("INSERT INTO categorie(code,nom) VALUES (?, ?)");
            $stmt->execute([$categorie->getCode(), $categorie->getNom()]);
            //$pdo->commit();
            return true;
        } catch (PDOException $e) {
            // GÃ©rer les erreurs d'insertion ici
           // $pdo->rollBack();
            return false;
        }
    } else {
        echo "ecehec enregistrement";
    }
    }

    public function modify ($categorie){
        if($categorie instanceof CategorieModel){
        try {
            $stmt = $this->connexion->pdo->prepare("UPDATE categorie SET nom = ? WHERE code = ?");
            $stmt->execute([$categorie->getNom(), $categorie->getCode()]);
            return true;
        } catch (PDOException $e) {
            // GÃ©rer les erreurs de mise Ã  jour ici
            return false;
        }
    }

    }
    public function delete($code) {
        try {
            $stmt = $this->connexion->pdo->prepare("DELETE FROM categorie WHERE code = ?");
            $stmt->execute([$code()]);
            return true;
        } catch (PDOException $e) {
            // Gérer les erreurs de suppression ici
            return false;
        }
    }


    
    
    
    public function list() {
        try {
            $stmt = $this->connexion->pdo->prepare("SELECT * FROM categorie");
            
            $stmt->execute();
           
    
            // Récupérer toutes les lignes résultantes en tant qu'objets CategorieModel
            $categories = $stmt->fetchAll(PDO::FETCH_CLASS, 'CategorieModel');
            var_dump($categories);
    
            return $categories;
        } catch (PDOException $e) {
            // Gérer les erreurs de récupération de données ici
            return false;
        }
    }
    

    
}
?>
