<?php
require_once __DIR__ . '/../../models/Cours.php'; // Inclure le fichier contenant la logique du modèle Cours
require_once __DIR__ . '/../../models/EmploiDuTemps.php'; // Inclure le modèle EmploiDuTemps

// Récupérer les cours existants
$cours = Cours::getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cours_id = $_POST['cours_id']; // Cours sélectionné
    $classe_id = $_POST['classe_id']; // Classe associée
    $jour = $_POST['jour'];
    $heure_debut = $_POST['heure_debut'];
    $heure_fin = $_POST['heure_fin'];

    try {
        // Appel au modèle pour créer un emploi du temps
        EmploiDuTemps::create($cours_id, $classe_id, $jour, $heure_debut, $heure_fin);
        header('Location: index.php'); // Redirection après création
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
    <title>Créer un Emploi du Temps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Créer un Emploi du Temps</h1>
        <a href="index.php" class="btn btn-secondary mb-4">Retour</a>
        <form method="post">
            <!-- Liste déroulante pour les cours -->
            <div class="mb-3">
                <label for="cours_id" class="form-label">Cours</label>
                <select class="form-control" id="cours_id" name="cours_id" required>
                    <?php foreach ($cours as $cour): ?>
                        <option value="<?= $cour['id'] ?>">
                            <?= htmlspecialchars($cour['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Champ pour la classe -->
            <div class="mb-3">
                <label for="classe_id" class="form-label">Classe</label>
                <input type="text" class="form-control" id="classe_id" name="classe_id" placeholder="Entrez l'ID de la classe" required>
            </div>
            <!-- Champ pour le jour -->
            <div class="mb-3">
                <label for="jour" class="form-label">Jour</label>
                <input type="text" class="form-control" id="jour" name="jour" placeholder="Entrez le jour (ex : Lundi)" required>
            </div>
            <!-- Heure de début -->
            <div class="mb-3">
                <label for="heure_debut" class="form-label">Heure de Début</label>
                <input type="time" class="form-control" id="heure_debut" name="heure_debut" required>
            </div>
            <!-- Heure de fin -->
            <div class="mb-3">
                <label for="heure_fin" class="form-label">Heure de Fin</label>
                <input type="time" class="form-control" id="heure_fin" name="heure_fin" required>
            </div>
            <!-- Bouton de soumission -->
            <button type="submit" class="btn btn-success">Créer</button>
        </form>
    </div>
</body>
</html>
