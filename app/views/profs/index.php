<?php
// Inclure le fichier Prof.php pour accéder aux méthodes du modèle
require_once __DIR__ . '/../../models/Prof.php';

// Récupérer tous les professeurs via le modèle
$profs = Prof::getAll();

// Suppression d'un professeur (si une requête DELETE est détectée)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    Prof::delete($_POST['delete_id']);
    header('Location: index.php'); // Rafraîchit la page après suppression
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Professeurs</title>
    <!-- Lien vers Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Liste des Professeurs</h1>
        <p class="text-center">Explorez tous les professeurs enregistrés dans l'application.</p>
        <div class="d-flex justify-content-between mb-4">
            <a href="../../public/index.php" class="btn btn-primary">Retour à l'accueil</a>
            <a href="create.php" class="btn btn-success">Créer un Professeur</a>
        </div>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Matière</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
    <?php if (!empty($profs)): ?>
        <?php foreach ($profs as $prof): ?>
            <tr>
                <td><?= htmlspecialchars($prof['id']) ?></td>
                <td><?= htmlspecialchars($prof['nom'] ?? 'Non défini') ?></td>
                <td><?= htmlspecialchars($prof['prenom'] ?? 'Non défini') ?></td>
                <td><?= htmlspecialchars($prof['email'] ?? 'Non défini') ?></td>
                <td><?= htmlspecialchars($prof['specialite'] ?? 'Non défini') ?></td>
                <td>
                    <a href="edit.php?id=<?= $prof['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="index.php" method="post" class="d-inline">
                        <input type="hidden" name="delete_id" value="<?= $prof['id'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce professeur ?')">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6" class="text-center">Aucun professeur trouvé.</td>
        </tr>
    <?php endif; ?>
</tbody>

        </table>
    </div>

    <!-- Script JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
