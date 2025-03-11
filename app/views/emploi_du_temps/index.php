<?php
// Inclure le fichier EmploiDuTemps.php pour accéder aux méthodes du modèle
require_once __DIR__ . '/../../models/EmploiDuTemps.php';

// Récupérer tous les emplois du temps via le modèle
$emplois = EmploiDuTemps::getAll();

// Suppression d'un emploi du temps (si une requête DELETE est détectée)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    EmploiDuTemps::delete($_POST['delete_id']);
    header('Location: index.php'); // Rafraîchit la page après suppression
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Emplois du Temps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Liste des Emplois du Temps</h1>
        <p class="text-center">Explorez tous les emplois du temps disponibles dans l'application.</p>
        <div class="d-flex justify-content-between mb-4">
            <a href="../../public/index.php" class="btn btn-primary">Retour à l'accueil</a>
            <a href="create.php" class="btn btn-success">Ajouter un Emploi du Temps</a>
        </div>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Cours</th>
                    <th>Classe</th>
                    <th>Jour</th>
                    <th>Heure Début</th>
                    <th>Heure Fin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($emplois)): ?>
                    <?php foreach ($emplois as $emploi): ?>
                        <tr>
                            <td><?= htmlspecialchars($emploi['id']) ?></td>
                            <td><?= htmlspecialchars($emploi['cours_id']) ?></td>
                            <td><?= htmlspecialchars($emploi['classe_id']) ?></td>
                            <td><?= htmlspecialchars($emploi['jour']) ?></td>
                            <td><?= htmlspecialchars($emploi['heure_debut']) ?></td>
                            <td><?= htmlspecialchars($emploi['heure_fin']) ?></td>
                            <td>
                                <a href="edit.php?id=<?= $emploi['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                                <form action="index.php" method="post" class="d-inline">
                                    <input type="hidden" name="delete_id" value="<?= $emploi['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cet emploi du temps ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Aucun emploi du temps trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
