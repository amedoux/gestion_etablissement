<?php
require_once __DIR__ . '/../../models/Cours.php';

// Récupérer le cours par ID
if (isset($_GET['id'])) {
    $cour = Cours::getById($_GET['id']);
    if (!$cour) {
        die("Cours introuvable.");
    }
} else {
    die("ID du cours manquant.");
}

// Mettre à jour le cours
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prof_id = $_POST['prof_id'];

    if (!empty($nom) && !empty($prof_id)) {
        Cours::update($id, $nom, $description, $prof_id);
        header('Location: index.php'); // Redirection après modification
        exit();
    } else {
        $error = "Tous les champs obligatoires doivent être remplis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Cours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Modifier un Cours</h1>
        <a href="index.php" class="btn btn-secondary mb-4">Retour</a>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($cour['id']) ?>">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom du Cours</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($cour['nom']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description"><?= htmlspecialchars($cour['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="prof_id" class="form-label">ID du Professeur</label>
                <input type="number" class="form-control" id="prof_id" name="prof_id" value="<?= htmlspecialchars($cour['prof_id']) ?>" required>
            </div>
            <button type="submit" class="btn btn-warning">Enregistrer les modifications</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
