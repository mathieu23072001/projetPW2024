<?php
include_once '../controllers/AuthController.php';

class ContactController {

    private $contactDAO;

    public function __construct($contactDAO) {
        $this->contactDAO = $contactDAO;
    }

    // Afficher la liste des contacts
    public function showList() {

        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }
        $contacts = $this->contactDAO->list();
        
        return $contacts;
    }

    
    // Ajouter un nouveau contact
    public function addContact($contactData) {

        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }
        $contact = new ContactModel();
        $contact->setNom($contactData['nom']);
        $contact->setPrenom($contactData['prenom']);
        $contact->setEmail($contactData['email']);
        $contact->setTelephone($contactData['telephone']);

        $success = $this->contactDAO->create($contact);
        if ($success) {
            
            echo "contact ajouté";
            exit;
        } else {
            echo "erreur lors de l'ajout";
        }
    }

    // Modifier un contact
    public function modifyContact($id,$contactData) {

        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }

         // Récupérez le contact par son id
         $contact = $this->contactDAO->getContact($id);

        if ($contact) {
            $contact->setNom($contactData['nom']);
            $contact->setPrenom($contactData['prenom']);
            $contact->setEmail($contactData['email']);
            $contact->setTelephone($contactData['telephone']);

            $success = $this->contactDAO->modify($contact);
        
            if ($success) {
                echo "contact mis à jour avec succès.";
            } else {
                echo "Erreur lors de la mise à jour de la categorie.";
            }
        } else {
            echo "contact non trouvé";
        }
    }

    // Supprimer un contact
    public function deleteContact($idContact) {

        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }

        $success = $this->contactDAO->delete($idContact);
        if ($success) {
            // Rediriger vers la liste des contacts après la suppression
            //header('Location: liste_contacts.php');
            echo "suppression bien effectué";
            exit;
        } else {
            echo "suppression non effectué";
        }
    }
}

require_once("../config/config.php");
require_once("../classes/models/Connexion.php");
require_once("../classes/models/ContactModel.php");
require_once("../classes/dao/ContactDAO.php");

$contactDAO=new ContactDAO(new Connexion());

$contactController = new ContactController($contactDAO);

// tester la création d'un contact

$contactData = [
    'nom' => 'Robert',
    'prenom'=> 'Fabrice',
    'email'=>  'fab@gmail.com',
    'telephone'=>'90473937' 
];

$contactController->addContact($contactData);


// tester la modification d'un contact

$updatedContactData = [
    'nom' => 'daa',
    'prenom'=> 'ruru',
    'email'=> 'daa@gmail.com',
    'telephone'=> '890932372',

];

$contactController->modifyContact(32,$updatedContactData);


// tester la supression d'un contact (a condition qu'elle ne soit pas clé étrangère pour une donnée dans une autre table)

$contactController->deleteContact(33);

// tester l'affichage des contacts

$conts= $contactController->showList();
foreach ($conts as $cont) {
    echo "<li>{$cont->getNom()} (prenom: {$cont->getEmail()})</li>";
}
echo "</ul>";



?>
