<?php
include_once '../controllers/AuthController.php';
require_once("../config/config.php");
require_once("../classes/models/Connexion.php");
require_once("../classes/models/CategorieModel.php");
require_once("../classes/models/ContactModel.php");
require_once("../classes/models/EducateurModel.php");
require_once("../classes/dao/EducateurDAO.php");
require_once("../classes/dao/CategorieDAO.php");
require_once("../classes/dao/ContactDAO.php");
require_once("../controllers/EducateurController.php"); 

$contactDAO=new ContactDAO(new Connexion());
$categorieDAO=new CategorieDAO(new Connexion());

$educateurDAO=new EducateurDAO(new Connexion(), $categorieDAO, $contactDAO);

$contacts = $contactDAO->list();
$categories = $categorieDAO->list();


$educateurController = new EducateurController($educateurDAO);
$numeroLicence= '';
$nom = '';
$prenom = '';
$category = null;
$contact0 = null;
$email = '';
$pwd = '';
$isAdmin = false;
if (isset($_SESSION['modify_educateur'])) {
    $educateur = $educateurDAO->getEducateurById($_SESSION['modify_educateur']);
    $numeroLicence = $educateur->getNumeroLicence();
    $nom = $educateur->getNom();
    $prenom= $educateur->getPrenom();
    $category = $educateur->getCategorie();
    $contact0= $educateur->getContact();
    $email = $educateur->getEmail();
    $pwd = $educateur->getPwd();
    $isAdmin = $educateur->getIsAdmin();
    unset($_GET['modify']);
    unset($_SESSION['modify_educateur']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educateur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="views/styles.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="../views/dashboard.php">Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <!-- Utilisez un formulaire pour gérer la déconnexion -->
                <form action="../controllers/AuthController.php" method="POST">
    <input type="hidden" name="logout" value="true">
    <button type="submit" class="btn btn-link" name="logout">Logout</button>
</form>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="text-center mb-4">Ajouter un éducateur</h2>
                    <form id="contactForm" action="../controllers/EducateurController.php" method="POST">
                    <div class="form-group">
                            <label for="nom">Numero Licence :</label>
                            <input type="text" class="form-control" id="numeroLicence" name="numeroLicence" value="<?php echo $numeroLicence; ?>" required>
                        </div>    
                    <div class="form-group">
                            <label for="nom">Nom:</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $nom; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prenom:</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $prenom; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="categories">Categorie:</label>
                            <select id="categorie" name="categorie" required>
                            <?php
                                foreach ($categories as $categorie) {
                                    echo "<option value=\"{$categorie->getCode()}\" " . (($category?->getCode() == $categorie->getCode()) ? "selected" : "") . ">{$categorie->getNom()}</option>";
                                }
                            ?>
                            </select>
                        </div>
                        <div class="form-group">
                 <label for="contacts">Contact:</label required>
                 <select id="contact" name="contact">
               <option value="" <?php echo (!$contact0 ? "selected" : ""); ?>>-- Sélectionnez un contact --</option>
        <?php
            foreach ($contacts as $contact) {
                echo "<option value=\"{$contact->getId()}\" " . (($contact0?->getId() == $contact->getId()) ? "selected" : "") . ">{$contact->getNom()} {$contact->getPrenom()}</option>";
            }
        ?>
    </select>
</div>



                        <div class="form-group">
                            <label for="email">Email :</label>
                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                        </div>    
                    <div class="form-group">
                            <label for="pwd">Mot de passe:</label>
                            <input type="password" class="form-control" id="nom" name="pwd" value="<?php echo $pwd; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="isAdmin">Je suis administrateur :</label>
                            <label>
                            <input type="radio" name="isAdmin" value="true" <?php echo $isAdmin == 1 ? "checked" : ""; ?>>
                                Oui
                            </label>
                            <label>
                                <input type="radio" name="isAdmin" value="false" <?php echo $isAdmin== 0 ? "checked" : ""; ?> >
                                Non
                            </label>
                        </div>


                        <button type="submit" class="btn btn-primary btn-block" name="submit">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>

        
        <div class="col-lg-12">
                <h2 class="text-center mb-8">Liste des éducateurs</h2>
                    <table border="1" class="col-lg-12">
                        <thead>
                            <tr>
                            <th class="col-lg-1">Numero</th>
                                <th class="col-lg-1">Nom</th>
                                <th class="col-lg-1">Prenom</th>
                                <th class="col-lg-2">Categorie</th>
                                <th class="col-lg-2">Contact</th>
                                <th class="col-lg-1">Email</th>
                                <th class="col-lg-1">Admin</th>
                                <th class="col-lg-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Utilisation d'une boucle for pour générer les lignes du tableau
                                $educateurs = $educateurController->showList();
                                foreach ($educateurs as $educateur ) {
                                    echo "<tr>";
                                    echo "<td> {$educateur->getNumeroLicence()}</td>";
                                    echo "<td> {$educateur->getNom()}</td>";
                                    echo "<td>{$educateur->getPrenom()}</td>";
                                    echo "<td> {$educateur->getCategorie()?->getNom()}</td>";
                                    echo "<td>{$educateur->getContact()?->getNom()} {$educateur->getContact()?->getPrenom()}</td>";
                                    echo "<td> {$educateur->getEmail()}</td>";
                                    echo "<td>" . (($educateur->getIsAdmin() == 1) ? "Oui" : "Non") . "</td>";

                                    echo "<td> <a href = \"../controllers/EducateurController.php?modify={$educateur->getNumeroLicence()}\" ><button name=\"modify\">Modifier</button></a>
                                    <a href = \"../controllers/EducateurController.php?id={$educateur->getNumeroLicence()}\" ><button name=\"delete\">Supprimer</button>
                                    </a></td>";
                                    echo "</tr>";
                                }
                           ?>
                        </tbody>
                    </table>
                </div>
            </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>