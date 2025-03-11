<?php
require_once __DIR__ . '/../../models/Prof.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $matiere = trim($_POST['matiere']);

    if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($matiere)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            try {
                Prof::create($nom, $prenom, $email, $matiere);
                echo "<script>alert('Professeur créé avec succès !'); window.location.href='index.php';</script>";
                
                exit();
            } catch (Exception $e) {
                $error = "Erreur lors de la création du professeur : " . $e->getMessage();
            }
        } else {
            $error = "L'adresse email n'est pas valide.";
        }
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
    <title>Créer un Professeur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Créer un Professeur</h1>
        <a href="index.php" class="btn btn-secondary mb-4">Retour</a>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($nom ?? '') ?>" placeholder="Entrez le nom" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($prenom ?? '') ?>" placeholder="Entrez le prénom" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" placeholder="exemple@email.com" required>
            </div>
            <div class="mb-3">
                <label for="matiere" class="form-label">Matière</label>
                <input type="text" class="form-control" id="matiere" name="matiere" value="<?= htmlspecialchars($matiere ?? '') ?>" placeholder="Entrez la matière enseignée" required>
            </div>
            <button type="submit" class="btn btn-success">Créer</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
