<?php
// Inclure le fichier Cours.php pour accéder aux méthodes du modèle
require_once __DIR__ . '/../../models/Cours.php';

// Récupérer tous les cours via le modèle
$cours = Cours::getAll();

// Suppression d'un cours (si une requête DELETE est détectée)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    Cours::delete($_POST['delete_id']);
    header('Location: index.php'); // Rafraîchit la page après suppression
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Cours</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Liste des Cours</h1>
        <p class="text-center">Explorez tous les cours disponibles dans l'application.</p>
        <div class="d-flex justify-content-between mb-4">
            <a href="../../public/index.php" class="btn btn-primary">Retour à l'accueil</a>
            <a href="create.php" class="btn btn-success">Créer un Cours</a>
        </div>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Professeur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($cours)): ?>
                    <?php foreach ($cours as $cour): ?>
                        <tr>
                            <td><?= htmlspecialchars($cour['id']) ?></td>
                            <td><?= htmlspecialchars($cour['nom']) ?></td>
                            <td><?= htmlspecialchars($cour['description']) ?></td>
                            <td>
                    <?= htmlspecialchars($cour['prof_nom'] ?? 'Aucun') ?>
                    <?= htmlspecialchars($cour['prof_prenom'] ?? '') ?>
                </td>
                            <td>
                                <a href="edit.php?id=<?= $cour['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                                <form action="index.php" method="post" class="d-inline">
                                    <input type="hidden" name="delete_id" value="<?= $cour['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce cours ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Aucun cours trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Script JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
