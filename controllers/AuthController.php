<?php
session_start();
// Controlleur de gestion des differents aspects de connexion

require_once '../controllers/AuthController.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['pwd'];
        AuthController::login($email, $password);
    }

    if (isset($_POST['logout'])) {
        AuthController::logout();
    }
}

class AuthController {
    
    // Fonction pour effectuer la connexion
    public static function login($email, $password) {
        $pdo = new PDO("mysql:host=localhost;dbname=myClub", "root");

        $stmt = $pdo->prepare("SELECT * FROM licencie WHERE email = ? AND isAdmin = 1");
        $stmt->execute([$email]);

        if ($educateur = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Vérifiez le mot de passe haché avec password_verify()
            if (password_verify($password, $educateur['pwd'])) {
                $_SESSION['educateur_id'] = $educateur['numeroLicence'];
                $_SESSION['educateur_email'] = $educateur['email'];
                $_SESSION['auth'] = true;
                $_SESSION['last_activity'] = time(); // Met à jour le timestamp de la dernière activité

                header('Location: ../views/dashboard.php');
                exit;
            }
        }

        // Authentification échouée
        header('Location: ../views/login.php?error=1');
        exit;
    }


    // Fonction pour effectuer la déconnexion
    public static function logout() {
        // Détruit toutes les variables de session
        session_unset();
        // Détruit la session
        session_destroy();
        // Redirige vers la page de connexion
        header('Location: ../views/login.php');
        exit;
    }

    // Vérifie si l'utilisateur est connecté
    public static function isUserLoggedIn() {
        return isset($_SESSION['auth']) && $_SESSION['auth'] === true;
    }

    // Vérifie le temps d'inactivité et déconnecte l'utilisateur après 5 minutes
    public static function checkInactivityTimeout() {
        $timeout = 300; // 5 minutes en secondes
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
            // Si le temps d'inactivité dépasse le délai, effectue la déconnexion
            self::logout();
        } else {
            // Met à jour le timestamp de la dernière activité
            $_SESSION['last_activity'] = time();
        }
    }
}

// Vérifie si l'utilisateur est déjà connecté
if (AuthController::isUserLoggedIn()) {
    // Vérifie le temps d'inactivité
    AuthController::checkInactivityTimeout();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Si une requête POST est reçue et que le bouton de connexion est soumis, tente la connexion
    $email = $_POST['email'];
    $password = $_POST['pwd'];
    AuthController::login($email, $password);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    // Si une requête POST est reçue et que le bouton de déconnexion est soumis, effectue la déconnexion
    AuthController::logout();
}
?>
