<?php
include_once '../controllers/AuthController.php';
require_once("../config/config.php");
require_once("../classes/models/Connexion.php");
require_once("../classes/models/CategorieModel.php");
require_once("../classes/dao/ContactDAO.php");
require_once("../controllers/ContactController.php"); 

$contactDAO=new ContactDAO(new Connexion());
$contactController = new ContactController($contactDAO);
$nom = '';
$prenom = '';
$email = '';
$telephone = '';
if (isset($_SESSION['modify_contact'])) {
    $contact = $contactDAO->getContact($_SESSION['modify_contact']);
    $nom = $contact->getNom();
    $prenom= $contact->getPrenom();
    $email = $contact->getEmail();
    $telephone= $contact->getTelephone();
    unset($_GET['modify']);
    unset($_SESSION['modify_contact']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
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
                    <h2 class="text-center mb-4">Ajouter un contact</h2>
                    <form id="contactForm" action="../controllers/ContactController.php" method="POST">
                        <div class="form-group">
                            <label for="nom">Nom:</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $nom; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prenom:</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo $prenom; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="telephone">Téléphone:</label>
                            <input type="text" class="form-control" id="telephone" name="telephone" value="<?php echo $telephone; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" name="submit">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>

        
        <div class="col-lg-12">
                <h2 class="text-center mb-8">Liste des contacts</h2>
                    <table border="1" class="col-lg-12">
                        <thead>
                            <tr>
                                <th class="col-lg-2">Nom</th>
                                <th class="col-lg-2">Prenom</th>
                                <th class="col-lg-2">Email</th>
                                <th class="col-lg-2">Téléphone</th>
                                <th class="col-lg-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Utilisation d'une boucle for pour générer les lignes du tableau
                                $contacts = $contactController->showList();
                                foreach ($contacts as $contact ) {
                                    echo "<tr>";
                                    echo "<td> {$contact->getNom()}</td>";
                                    echo "<td>{$contact->getPrenom()}</td>";
                                    echo "<td> {$contact->getEmail()}</td>";
                                    echo "<td>{$contact->getTelephone()}</td>";
                                    echo "<td> <a href = \"../controllers/ContactController.php?modify={$contact->getId()}\" ><button name=\"modify\">Modifier</button></a>
                                    <a href = \"../controllers/ContactController.php?id={$contact->getId()}\" ><button name=\"delete\">Supprimer</button>
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