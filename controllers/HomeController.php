
<?php
include_once '../controllers/AuthController.php';

// Ce controllers a servi de de controlleur de test pour nos différentes fonctions.
class HomeController {
   private $datahubDAO;
    private $categorieDAO;
    private $contactDAO;
    private $licencieDAO;
    private $educateurDAO;

    public function __construct(EducateurDAO $educateurDAO) {
        $this->educateurDAO = $educateurDAO;
        //$this->contactDAO = $contactDAO;
        //$this->licencieDAO = $licencieDAO;
    }


    public function index() {

        // Pour controller si l'utilisateur est bien connecté

        if (!AuthController::isUserLoggedIn()) {
            // Rediriger vers la page de connexion s'il n'est pas connecté
            header('Location: ../views/login.php');
            exit;
        }

// // Vérifier si un fichier a été soumis
// if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
//     $fileTmpPath = $_FILES['csv_file']['tmp_name'];
//     $fileName = $_FILES['csv_file']['name'];
    


//   // Vérifier l'extension du fichier
//     $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
//     $allowedExtensions = ['csv'];
    
//     if (in_array($fileExtension, $allowedExtensions)) {
//         // Copier le fichier dans le répertoire souhaité
//         $uploadDirectory = '../controllers/fichiers/';
//         $destPath = $uploadDirectory."".$fileName;
//         move_uploaded_file($fileTmpPath, $destPath);

//        // die($destPath);

       

//         // À ce stade, le fichier a été téléchargé avec succès et vous pouvez utiliser votre classe DataHubDAO pour l'importer
        
//         $this->datahubDAO->insertCsvData($destPath);

//         // Faire d'autres actions si nécessaire...

//         // Rediriger ou afficher un message de succès
//         header('Location: ../views/dashboard.php');
//         exit;
//     } else {
//         // Extension non autorisée
//         header('Location: ../views/dashboard.php?error=extension');
//         exit;
//     }
// } else {
//     // Aucun fichier soumis ou une erreur s'est produite
//     header('Location: ../views/dashboard.php?error=upload');
//     exit;
//  }
    //     $licencie = new LicencieModel();
    //     $licencie->setNumeroLicence(2023);
    //     $licencie->setNom("koffi");
    //     $licencie->setPrenom("germain");
    //     $licencie->setContact(new ContactModel(1000,"ddd","eee@gmail.com","89093472"));
    //     $licencie->setcategorie((new CategorieModel("TZTZT","jijji")));
    //    // var_dump($licencie);
    //    // echo "****===========****".$licencie->getContact()->getNom();
    //     $this->licencieDAO->create($licencie);
    //     $contact = new ContactModel();
    //     //$contact->setID(29);
    //     $contact->setNom("kokou");
    //     $contact->setPrenom("ama");
    //     $contact->setTelephone("838303");
    //     $contact->setEmail("cecec@gmail.com");

    //     $contact1 = new ContactModel();
    //     $contact1->setId(28);
    //     $contact1->setNom("daa");
    //     $contact1->setPrenom("ruru");
    //     $contact1->setTelephone("89093472");
    //     $contact1->setEmail("eaa@gmail.com");

    //     $contact2 = new ContactModel();
    //     $contact2->setId(26);
    //     $contact2->setNom("daa");
    //     $contact2->setPrenom("ruru");
    //     $contact2->setTelephone("000111");
    //     $contact2->setEmail("eaa@gmail.com");
    //    // $this->contactDAO->create($contact);
    //    // $this->contactDAO->modify($contact2);
    //    // $this->contactDAO->delete($contact1);
    //     $this->contactDAO->deleteById(28);
          

        //  $contacts= $this->contactDAO->list();
        // foreach ($contacts as $contact) {
        //     var_dump($contact->getNom());
        //     echo "<li>{$contact->getNom()} (prenom: {$contact->getPrenom()})</li>";
        // }
        // echo "</ul>";


      
            // Créer un nouveau contact
            $nouveauContact = new ContactModel();
            $nouveauContact->setId(32);
            $nouveauContact->setNom("daa");
            $nouveauContact->setPrenom("ruru");
            $nouveauContact->setEmail("eaa@gmail.com");
            $nouveauContact->setTelephone("890932372");

            // // Créer une nouvel catégorie
            $nouvelCategorie = new CategorieModel();
            $nouvelCategorie->setCode("RH");
            $nouvelCategorie->setNom("rsHH");

        
            // // Créer un nouveau licencié
            $educateur = new EducateurModel();
            $educateur->setNumeroLicence(5);
            $educateur->setNom("Yao");
            $educateur->setPrenom("phillipe");
            $educateur->setContact($nouveauContact);
            $educateur->setCategorie($nouvelCategorie);
            $educateur->setEmail("yao@gmail.com");
            $educateur->setPwd("1234");
            $educateur->setIsAdmin(1);
           // var_dump($licencie);

           $this->educateurDAO->modify($educateur);



        //    $educateurs =  $this->educateurDAO->list();

        //   foreach ($educateurs as $educateur) {
        //         //var_dump($contact->getNom());
        //         echo "<li>{$educateur->getNom()} (prenom: {$educateur->getPrenom()})</li>";
        //     }
        //     echo "</ul>";
        
            
           
           

          
        
    }
}

require_once("../config/config.php");
require_once("../classes/models/Connexion.php");
require_once("../classes/models/CategorieModel.php");
require_once("../classes/models/LicencieModel.php");
require_once("../classes/models/ContactModel.php");
require_once("../classes/models/DatahubModel.php");
require_once("../classes/models/EducateurModel.php");
require_once("../classes/dao/CategorieDAO.php");
require_once("../classes/dao/LicencieDAO.php");
require_once("../classes/dao/ContactDAO.php");
require_once("../classes/dao/DatahubDAO.php");
require_once("../classes/dao/EducateurDAO.php"); 
$categorieDAO=new CategorieDAO(new Connexion());
$contactDAO=new ContactDAO(new Connexion());
$datahubDAO=new DatahubDAO(new Connexion());
$educateurDAO=new EducateurDAO(new Connexion(),$categorieDAO,$contactDAO);
$licencieDAO=new LicencieDAO(new Connexion(),$categorieDAO,$contactDAO);
$controller=new HomeController($educateurDAO);
$controller->index();

?>
