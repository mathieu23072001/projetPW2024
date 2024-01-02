<?php
include_once '../controllers/AuthController.php';

class CategorieController {

    private $categorieDAO;

    public function __construct($categorieDAO) {
        $this->categorieDAO = $categorieDAO;
    }

    // Afficher la liste des catégories
    public function showList() {
        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }
        $categories = $this->categorieDAO->list();

        
          
        return $categories;
    }


    // Ajouter une nouvelle catégorie
    public function addCategorie($categorieData) {

        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }

        $categorie = new CategorieModel();
        $categorie->setCode($categorieData['code']);
        $categorie->setNom($categorieData['nom']);
        $success = $this->categorieDAO->create($categorie);

        if ($success) {
            // Rediriger vers la liste des catégories après l'ajout
           // header('Location: ../views/categorie/List.php');
           echo "categorie créé";
            exit;
        } else {
            echo "erreur lors de la création";
        }
    }

    // Modifier une catégorie
    public function modifyCategorie($code,$categorieData) {

        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }
        // Récupérez la categorie par son code
        $categorie = $this->categorieDAO->getCategorie($code);

        if($categorie){
            $categorie->setNom($categorieData['nom']);
            $success = $this->categorieDAO->modify($categorie);
        
            if ($success) {
                echo "categorie mis à jour avec succès.";
            } else {
                echo "Erreur lors de la mise à jour de la categorie.";
            }

        }else{
            echo "categorie non trouvé";
        }

    }

    // Supprimer une catégorie
    public function deleteCategorie($codeCategorie) {

        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }

        $success = $this->categorieDAO->delete($codeCategorie);
        if ($success) {
            echo "categorie supprimée";
        } else {
            echo "echec de suppression";
        }
    }
}

require_once("../config/config.php");
require_once("../classes/models/Connexion.php");
require_once("../classes/models/CategorieModel.php");
require_once("../classes/dao/CategorieDAO.php");

$categorieDAO=new CategorieDAO(new Connexion());

$categorieController = new CategorieController($categorieDAO);

// tester la création d'une catégorie

$categorieData = [
    'code' => 'SH',
    'nom' => 'Shonen'   
];

$categorieController->addCategorie($categorieData);


// tester la modification d'une catégorie

$updatedCategorieData = [
    'nom' => 'Shosho',    
];

$categorieController->modifyCategorie("SH",$updatedCategorieData);

// tester la suppression d'une categorie

$categorieController->deleteCategorie('SH');


// tester l'affichage de la liste des categories
$cats= $categorieController->showList();
foreach ($cats as $cat) {
    echo "<li>{$cat->getCode()} (libelle: {$cat->getNom()})</li>";
}
echo "</ul>";





?>
