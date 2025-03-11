<?php
require_once __DIR__ . '/../../models/Prof.php';

// Récupérer le professeur par ID
if (isset($_GET['id'])) {
    $prof = Prof::getById($_GET['id']);
    if (!$prof) {
        die("Professeur introuvable.");
    }
} else {
    die("ID du professeur manquant.");
}

// Mettre à jour le professeur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $matiere = $_POST['matiere'];

    if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($matiere)) {
        Prof::update($id, $nom, $prenom, $email, $matiere);
        header('Location: index.php'); // Redirection après modification
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
    <title>Modifier un Professeur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Modifier un Professeur</h1>
        <a href="index.php" class="btn btn-secondary mb-4">Retour</a>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($prof['id']) ?>">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($prof['nom']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($prof['prenom']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($prof['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="matiere" class="form-label