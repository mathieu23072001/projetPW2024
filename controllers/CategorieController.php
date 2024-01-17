<?php
include_once '../controllers/AuthController.php';
require_once("../config/config.php");
require_once("../classes/models/Connexion.php");
require_once("../classes/models/CategorieModel.php");
require_once("../classes/dao/CategorieDAO.php");

$categorieDAO=new CategorieDAO(new Connexion());

$categorieController = new CategorieController($categorieDAO);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $code = $_POST['code'];
        $nom = $_POST['nom'];
        $categorieController->addCategorie([
            'code' => $code, 
            'nom' => $nom
            ]
        );
    }

    if (isset($_POST['logout'])) {
        AuthController::logout();
    }
}

if (isset($_GET['code'])) {
    $categorieController->deleteCategorie($_GET['code']);
    unset($_GET['code']);
    header('Location: ../views/categorieView.php');
}
if (isset($_GET['modify'])) {
    $categorieController->modifyBack();
}

class CategorieController {

    private $categorieDAO;

    public function __construct($categorieDAO) {
        $this->categorieDAO = $categorieDAO;
    }

    public function modifyBack() {
        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }
        $_SESSION['modify_category'] = $_GET['modify'];
        unset($_GET['modify']);
        header('Location: ../views/categorieView.php');
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
            header('Location: ../views/categorieView.php');
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

/*require_once("../config/config.php");
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
echo "</ul>";*/





?>
