<?php
require_once("../classes/dao/DaoInterface.php");
class CategorieDAO implements DaoInterface {
    private $connexion;

    public function __construct(Connexion $connexion) {
        $this->connexion = $connexion;
    }


    // récupérer l'objet categorie grace à son code
    public function getCategorie($code)
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
       
        return null;
    }
}

    // Verifie si la categorie existe
    public function isCategorieExists($code) {
        try {
            $stmt = $this->connexion->pdo->prepare("SELECT COUNT(*) as count FROM categorie WHERE code = ?");
            $stmt->execute([$code]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return ($result['count'] > 0);
        } catch (PDOException $e) {
            
            return false;
        }
    }


    public function create($categorie) {
        if($categorie instanceof CategorieModel){
            $pdo = $this->connexion->pdo;
            try {
                // Vérifier si le code de la catégorie existe déjà
                if ($this->isCategorieExists($categorie->getCode())) {
                    $this->modify($categorie);
                    return true;
                }
                ///$pdo->beginTransaction();
                $stmt = $pdo->prepare("INSERT INTO categorie(code,nom) VALUES (?, ?)");
                $stmt->execute([$categorie->getCode(), $categorie->getNom()]);
                //$pdo->commit();
                return true;
            } catch (PDOException $e) {
            
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
            
            return false;
        }
    }

    }
    public function delete($code) {
        try {
            $stmt = $this->connexion->pdo->prepare("DELETE FROM categorie WHERE code = ?");
            $stmt->execute([$code]);
            return true;
        } catch (PDOException $e) {
            
            return false;
        }
    }


    
    
    
    public function list() {
        try {
            $stmt = $this->connexion->pdo->prepare("SELECT * FROM categorie");
            
            $stmt->execute();
        
            $categories = $stmt->fetchAll(PDO::FETCH_CLASS, 'CategorieModel');
            //var_dump($categories);
    
            return $categories;
        } catch (PDOException $e) {
          
            return false;
        }
    }
    

    
}
?>
