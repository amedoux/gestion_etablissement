<?php
require_once __DIR__ . '/../../models/Etudiant.php';

// Vérifier si une requête POST a été envoyée pour supprimer un étudiant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    try {
        Etudiant::delete($delete_id); // Appel à la méthode de suppression
        header('Location: index.php'); // Rafraîchir la page après suppression
        exit();
    } catch (Exception $e) {
        die("Erreur lors de la suppression de l'étudiant : " . $e->getMessage());
    }
}

// Récupérer tous les étudiants via le modèle
$etudiants = Etudiant::getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Liste des Étudiants</h1>
        <p class="text-center">Explorez tous les étudiants inscrits dans l'application.</p>
        <div class="d-flex justify-content-between mb-4">
            <a href="../../public/index.php" class="btn btn-primary">Retour à l'accueil</a>
            <a href="create.php" class="btn btn-success">Ajouter un Étudiant</a>
        </div>
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Classe</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($etudiants)): ?>
                    <?php foreach ($etudiants as $etudiant): ?>
                        <tr>
                            <td><?= htmlspecialchars($etudiant['id']) ?></td>
                            <td><?= htmlspecialchars($etudiant['nom']) ?></td>
                            <td><?= htmlspecialchars($etudiant['prenom'] ?? 'Non défini') ?></td>
                            <td><?= htmlspecialchars($etudiant['email']) ?></td>
                            <td><?= htmlspecialchars($etudiant['classe'] ?? 'Non définie') ?></td>

                            <td>
                                <!-- Bouton Modifier -->
                                <a href="edit.php?id=<?= $etudiant['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                                <!-- Bouton Supprimer -->
                                <form action="index.php" method="post" class="d-inline">
                                    <input type="hidden" name="delete_id" value="<?= $etudiant['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cet étudiant ?')">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Aucun étudiant trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
