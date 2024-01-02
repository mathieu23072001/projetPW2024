<?php
include_once '../controllers/AuthController.php';


class EducateurController {

    private $educateurDAO;

    public function __construct($educateurDAO) {
        $this->educateurDAO = $educateurDAO; 
    }


    // Afficher la liste des educateurs
    public function showList() {

        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }

        $educateurs = $this->educateurDAO->list();
       

        return $educateurs;
    }

    public function createEducateur($educateurData) {

        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }

        $success = $this->educateurDAO->create($educateurData);
        if ($success) {
            // Rediriger vers la liste des licenciés après l'ajout
           // header('Location: liste_licencies.php');
           echo "enregistrement réussi";
            exit;
        } else {
            echo "enregistrement echoué";
        }
    }

    

    public function modifyEducateur($numeroLicence, $educateurData) {

        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }
        // Récupérez l'éducateur par son numéro de licence
        $educateur = $this->educateurDAO->getEducateurById($numeroLicence);

        if ($educateur) {
            
            $educateur->setNom($educateurData->getNom());
            $educateur->setPrenom($educateurData->getPrenom());
            $educateur->setEmail($educateurData->getEmail());
            $educateur->setPwd($educateurData->getPwd()); 
            $educateur->setIsAdmin($educateurData->getIsAdmin());
            $educateur->setCategorie($educateurData->getCategorie());
            $educateur->setContact($educateurData->getContact());

            $success = $this->educateurDAO->modify($educateur);

            if ($success) {
                echo "Educateur mis à jour avec succès.";
            } else {
                echo "Erreur lors de la mise à jour de l'éducateur.";
            }
        } else {
            echo "Educateur non trouvé.";
        }
    }

    public function deleteEducateur($numeroLicence) {

        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }
        // Supprimez l'éducateur par son numéro de licence
        $success = $this->educateurDAO->delete($numeroLicence);

        if ($success) {
            echo "Educateur supprimé avec succès.";
        } else {
            echo "Erreur lors de la suppression de l'éducateur.";
        }
    }
}

require_once("../config/config.php");
require_once("../classes/models/Connexion.php");
require_once("../classes/models/EducateurModel.php");
require_once("../classes/models/CategorieModel.php");
require_once("../classes/models/ContactModel.php");
require_once("../classes/models/LicencieModel.php");
require_once("../classes/dao/EducateurDAO.php");
require_once("../classes/dao/CategorieDAO.php");
require_once("../classes/dao/ContactDAO.php");  


$categorieDAO=new CategorieDAO(new Connexion());
$contactDAO=new ContactDAO(new Connexion());

$educateurDAO=new EducateurDAO(new Connexion(),$categorieDAO,$contactDAO);

$educateurController = new EducateurController($educateurDAO);

// Exemple de création d'un éducateur
$contactData = [
    'id' => 35,
    'nom' => 'Dupont',
    'prenom' => 'Jean',
    'email' => 'jean.dupont@example.com',
    'telephone' => '0123456789',
];

$categorieData = [
    'code' => 'SH',
    'nom' => 'Shonen',
];

$educateurData = [
    'numeroLicence' => 2001,
    'nom' => 'Aka',
    'prenom' => 'Angelic',
    'email'=> 'ange@gmail.com,',
    'pwd'=> '123',
    'isAdmin'=> 1
    
];

$contact = new ContactModel();
$contact->setNom($contactData['nom'])
    ->setPrenom($contactData['prenom'])
    ->setEmail($contactData['email'])
    ->setTelephone($contactData['telephone'])
    ->setId($contactData['id']);

$categorie = new CategorieModel();
$categorie->setCode($categorieData['code'])
    ->setNom($categorieData['nom']);

$educateur = new EducateurModel();
$educateur->setNumeroLicence($educateurData['numeroLicence'])
    ->setNom($educateurData['nom'])
    ->setPrenom($educateurData['prenom'])
    ->setEmail($educateurData['email'])
    ->setPwd($educateurData['pwd'])
    ->setIsAdmin($educateurData['isAdmin'])
    ->setContact($contact)
    ->setCategorie($categorie);


$educateurController->createEducateur($educateur);


// Exemple de mise à jour d'un éducateur

$educateurController->modifyEducateur(2001,$educateur);


// Exemple de suppression d'un éducateur
$educateurController->deleteEducateur(12300);


// Exemple affichage de la liste des educateurs

$educateurs= $educateurController->showList();
foreach ($educateurs as $educateur) {
    echo "<li>{$educateur->getNom()} (prenom: {$educateur->getPrenom()})
    (cat: {$educateur->getCategorie()->getNom()})
    (cont: {$educateur->getContact()?->getId()})
    
    
    </li>";
}
echo "</ul>";
