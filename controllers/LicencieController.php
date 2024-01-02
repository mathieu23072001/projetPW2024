<?php

include_once '../controllers/AuthController.php';

class LicencieController {

    private $licencieDAO;

    public function __construct($licencieDAO) {
        $this->licencieDAO = $licencieDAO;
    }

    // Afficher la liste des licenciés
    public function showList() {

        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }
        $licencies = $this->licencieDAO->list();
        
        // Afficher la liste des licenciés dans la vue
        // ...

        return $licencies;
    }


    // Ajouter un nouveau licencié
    public function addLicencie($licencieData) {

        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }

       
       // var_dump ($licencieData);

        $success = $this->licencieDAO->create($licencieData);
        if ($success) {
            // Rediriger vers la liste des licenciés après l'ajout
           // header('Location: liste_licencies.php');
           echo "enregistrement réussi";
            exit;
        } else {
            echo "enregistrement echoué";
        }
    }

    // Modifier un licencié
    public function modifyLicencie($numeroLicence,$licencieData) {

        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }

        // Récupérez le licencie par son numero
        $licencie = $this->licencieDAO->getLicencieByNumeroLicence($numeroLicence);
        if ($licencie) {
            $licencie->setNom($licencieData->getNom());
            $licencie->setPrenom($licencieData->getPrenom());
            $licencie->setCategorie($licencieData->getCategorie());
            $licencie->setContact($licencieData->getContact());

           $success= $this->licencieDAO->modify($licencie);
            
           if ($success) {
            echo "licencie mis à jour avec succès.";
        } else {
            echo "Erreur lors de la mise à jour du licencie.";
        }
        } else {
            echo "licencie non trouvé";
        }
    }

    // Supprimer un licencié
    public function deleteLicencie($numeroLicence) {

        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }

        $success = $this->licencieDAO->delete($numeroLicence);
        if ($success) {
            // Rediriger vers la liste des licenciés après la suppression
            //header('Location: liste_licencies.php');
            echo "licencie supprimé";
            exit;
        } else {
            echo "erreur de suppression";
        }
    }



    // Supprimer un le contact d'un licencié
    public function deleteContactLicencie($numeroLicence) {

        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }

        $success = $this->licencieDAO->deleteContactForLicencie($numeroLicence);
        if ($success) {
            // Rediriger vers la liste des licenciés après la suppression
            //header('Location: liste_licencies.php');
            echo "contact du licencie supprimé";
            exit;
        } else {
            echo "erreur de suppression";
        }
    }
}

require_once("../config/config.php");
require_once("../classes/models/Connexion.php");
require_once("../classes/models/LicencieModel.php");
require_once("../classes/models/CategorieModel.php");
require_once("../classes/models/ContactModel.php");
require_once("../classes/dao/LicencieDAO.php");
require_once("../classes/dao/CategorieDAO.php");
require_once("../classes/dao/ContactDAO.php");


$categorieDAO=new CategorieDAO(new Connexion());
$contactDAO=new ContactDAO(new Connexion());

$licencieDAO=new LicencieDAO(new Connexion(),$categorieDAO,$contactDAO);

$licencieController = new LicencieController($licencieDAO);

// tester la création d'un licencié

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

$licencieData = [
    'numeroLicence' => 123456,
    'nom' => 'Durand',
    'prenom' => 'Alissou'
    
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

$licencie = new LicencieModel();
$licencie->setNumeroLicence($licencieData['numeroLicence'])
    ->setNom($licencieData['nom'])
    ->setPrenom($licencieData['prenom'])
    ->setContact($contact)
    ->setCategorie($categorie);


$licencieController->addLicencie($licencie);

// tester la modification d'un licencié

$licencieController->modifyLicencie(123456,$licencie);

// tester la suppression d'un licencié

$licencieController->deleteLicencie(200112);

// tester la suppression d'un contact d'un licencié

$licencieController->deleteContactLicencie(5);


// tester l'affichage des licenciés

$licencies= $licencieController->showList();
foreach ($licencies as $licencie) {
    echo "<li>{$licencie->getNom()} (prenom: {$licencie->getPrenom()})
    (cat: {$licencie->getCategorie()->getNom()})
    (cont: {$licencie->getContact()?->getId()})
    
    
    </li>";
}
echo "</ul>";


?>
