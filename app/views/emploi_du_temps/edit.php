<?php
require_once __DIR__ . '/../../models/EmploiDuTemps.php';

$id = $_GET['id'];
$emploi = EmploiDuTemps::getById($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cours_id = $_POST['cours_id'];
    $classe_id = $_POST['classe_id'];
    $jour = $_POST['jour'];
    $heure_debut = $_POST['heure_debut'];
    $heure_fin = $_POST['heure_fin'];

    try {
        EmploiDuTemps::update($id, $cours_id, $classe_id, $jour, $heure_debut, $heure_fin);
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
    <title>Modifier un Emploi du Temps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Modifier un Emploi du Temps</h1>
        <a href="index.php" class="btn btn-secondary mb-4">Retour</a>
        <form method="post">
            <div class="mb-3">
                <label for="cours_id" class="form-label">Cours</label>
                <input type="text" class="form-control" id="cours_id" name="cours_id" value="<?= htmlspecialchars($emploi['cours_id']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="classe_id" class="form-label">Classe</label>
                <input type="text" class="form-control" id="classe_id" name="classe_id" value="<?= htmlspecialchars($emploi['classe_id']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="jour" class="form-label">Jour</label>
                <input type="text" class="form-control" id="jour" name="jour" value="<?= htmlspecialchars($emploi['jour']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="heure_debut" class="form-label">Heure de Début</label>
                <input type="time" class="form-control" id="heure_debut" name="heure_debut" value="<?= htmlspecialchars($emploi['heure_debut']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="heure_fin" class="form-label">Heure de Fin</label>
                <input type="time" class="form-control" id="heure_fin" name="heure_fin" value="<?= htmlspecialchars($emploi['heure_fin']) ?>" required>
            </div>
            <button type="submit" class="btn btn-warning">Enregistrer</button>
        </form>
    </div>
</body>
</html>
