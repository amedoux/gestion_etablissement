<?php
require_once __DIR__ . '/../../models/Classe.php';

// Récupérer toutes les classes à partir du modèle
$classes = Classe::getAll();

// Suppression d'une classe (si une demande DELETE est détectée)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    Classe::delete($_POST['delete_id']);
    header('Location: index.php'); // Rafraîchir la page après suppression
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Classes</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Conteneur principal -->
    <div class="container mt-5">
        <h1 class="text-center">Liste des Classes</h1>
        <p class="text-center">Explorez toutes les classes disponibles dans l'application.</p>
        <div class="d-flex justify-content-between mb-4">
            <a href="../../public/index.php" class="btn btn-primary">Retour à l'accueil</a>
            <a href="create.php" class="btn btn-success">Créer une Classe</a>
        </div>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Niveau</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($classes)): ?>
                    <?php foreach ($classes as $classe): ?>
                        <tr>
                            <td><?= htmlspecialchars($classe['id']) ?></td>
                            <td><?= htmlspecialchars($classe['nom']) ?></td>
                            <td><?= htmlspecialchars($classe['niveau']) ?></td>
                            <td>
                                <a href="edit.php?id=<?= $classe['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                                <form action="index.php" method="post" class="d-inline">
                                    <input type="hidden" name="delete_id" value="<?= $classe['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cette classe ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Aucune classe trouvée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Script JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
