

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles1.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Dashboard</a>
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

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Catégories</h5>
                    <p class="card-text">Gérer les catégories ici.</p>
                    <a href="../views/categorie/List.php" class="btn btn-primary">Voir les catégories</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Contacts</h5>
                    <p class="card-text">Gérer les contacts ici.</p>
                    <a href="#" class="btn btn-primary">Voir les contacts</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Licenciés</h5>
                    <p class="card-text">Gérer les licenciés ici.</p>
                    <a href="#" class="btn btn-primary">Voir les licenciés</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Educateurs</h5>
                    <p class="card-text">Gérer les educteurs ici.</p>
                    <a href="#" class="btn btn-primary">Voir les educateurs</a>
                </div>
            </div>
        </div>

        <form action="../controllers/HomeController.php" method="post" enctype="multipart/form-data">
    <input type="file" name="csv_file" accept=".csv">
    <button type="submit">Importer</button>
</form>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
