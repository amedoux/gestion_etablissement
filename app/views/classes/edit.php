<?php
require_once __DIR__ . '/../../models/Classe.php';

// Récupérer les détails de la classe par ID
if (isset($_GET['id'])) {
    $classe = Classe::getById($_GET['id']);
    if (!$classe) {
        die("Classe introuvable.");
    }
} else {
    die("ID de la classe manquant.");
}

// Mettre à jour la classe après soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $niveau = $_POST['niveau'];

    if (!empty($nom) && !empty($niveau)) {
        Classe::update($id, $nom, $niveau);
        header('Location: index.php'); // Redirection après la modification
        exit();
    } else {
        $error = "Tous les champs sont requis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Classe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Modifier une Classe</h1>
        <a href="index.php" class="btn btn-secondary mb-4">Retour</a>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" class="mb-4">
            <input type="hidden" name="id" value="<?= htmlspecialchars($classe['id']) ?>">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom de la Classe</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($classe['nom']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="niveau" class="form-label">Niveau</label>
                <input type="text" class="form-control" id="niveau" name="niveau" value="<?= htmlspecialchars($classe['niveau']) ?>" required>
            </div>
            <button type="submit" class="btn btn-warning">Enregistrer les Modifications</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
