<?php
require_once __DIR__ . '/../../models/Etudiant.php';
require_once __DIR__ . '/../../models/Classe.php'; // Inclure le modèle Classe

// Récupérer l'étudiant à partir de l'ID
$id = $_GET['id'] ?? null; // Récupération de l'ID depuis l'URL
if (!$id) {
    die("ID de l'étudiant manquant");
}

$etudiant = Etudiant::getById($id); // Récupérer les infos de l'étudiant
if (!$etudiant) {
    die("Étudiant introuvable");
}

// Récupérer les classes disponibles
$classes = Classe::getAll();
if (empty($classes)) {
    die("Aucune classe disponible pour assigner l'étudiant.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $classe_id = $_POST['classe_id'];

    // Validation des données du formulaire
    if (empty($nom) || empty($prenom) || empty($email) || empty($classe_id)) {
        die("Tous les champs sont obligatoires.");
    }

    try {
        Etudiant::update($id, $nom, $prenom, $email, $classe_id); // Mise à jour de l'étudiant
        header('Location: index.php'); // Redirection après modification
        exit();
    } catch (Exception $e) {
        die("Erreur : " . $e->getMessage());
    }
    
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Modifier un Étudiant</h1>
        <a href="index.php" class="btn btn-secondary mb-4">Retour</a>
        <form method="post">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($etudiant['nom']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($etudiant['prenom']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($etudiant['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="classe_id" class="form-label">Classe</label>
                <select class="form-control" id="classe_id" name="classe_id" required>
                    <?php foreach ($classes as $classe): ?>
                        <option value="<?= htmlspecialchars($classe['id']) ?>" <?= ($classe['id'] == ($etudiant['classe_id'] ?? null)) ? 'selected' : '' ?>>
    <?= htmlspecialchars($classe['nom']) ?>
</option>

                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-warning">Mettre à jour</button>
        </form>
    </div>
</body>
</html>
