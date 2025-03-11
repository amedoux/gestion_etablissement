<?php
require_once '../models/EmploiDuTemps.php'; // Inclusion du modèle EmploiDuTemps

class EmploiDuTempsController {
    // Afficher tous les emplois du temps (avec pagination et recherche)
    public function index() {
        $page = $_GET['page'] ?? 1; // Page actuelle (par défaut : 1)
        $limit = 10; // Nombre d'éléments par page
        $offset = ($page - 1) * $limit; // Calcul de l'offset

        $jour = $_GET['jour'] ?? ''; // Paramètre de recherche par jour (facultatif)

        if (!empty($jour)) {
            $emplois = EmploiDuTemps::searchByDay($jour); // Rechercher par jour
        } else {
            $emplois = EmploiDuTemps::getAll($limit, $offset); // Récupérer tous les emplois du temps
        }

        $total = EmploiDuTemps::count(); // Nombre total d'emplois du temps
        $pages = ceil($total / $limit); // Calcul du nombre de pages

        // Charger la vue pour afficher les emplois du temps
        require '../views/emploi_du_temps/index.php';
    }

    // Afficher le formulaire de création d'un emploi du temps
    public function create() {
        require '../views/emploi_du_temps/create.php'; // Vue pour le formulaire de création
    }

    // Enregistrer un nouvel emploi du temps
    public function store() {
        $cours_id = $_POST['cours_id'];
        $classe_id = $_POST['classe_id'];
        $jour = $_POST['jour'];
        $heure_debut = $_POST['heure_debut'];
        $heure_fin = $_POST['heure_fin'];

        try {
            // Appel au modèle pour créer un emploi du temps
            if (EmploiDuTemps::create($cours_id, $classe_id, $jour, $heure_debut, $heure_fin)) {
                header('Location: index.php?action=index'); // Redirection après succès
                exit;
            } else {
                throw new Exception("Erreur lors de la création de l'emploi du temps.");
            }
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    // Afficher le formulaire de modification d'un emploi du temps
    public function edit($id) {
        $emploi = EmploiDuTemps::getById($id); // Récupérer les données de l'emploi par son ID
        require '../views/emploi_du_temps/edit.php'; // Vue pour le formulaire de modification
    }

    // Mettre à jour un emploi du temps
    public function update($id) {
        $cours_id = $_POST['cours_id'];
        $classe_id = $_POST['classe_id'];
        $jour = $_POST['jour'];
        $heure_debut = $_POST['heure_debut'];
        $heure_fin = $_POST['heure_fin'];

        try {
            // Appel au modèle pour mettre à jour l'emploi du temps
            if (EmploiDuTemps::update($id, $cours_id, $classe_id, $jour, $heure_debut, $heure_fin)) {
                header('Location: index.php?action=index'); // Redirection après succès
                exit;
            } else {
                throw new Exception("Erreur lors de la mise à jour de l'emploi du temps.");
            }
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    // Supprimer un emploi du temps
    public function destroy($id) {
        try {
            // Appel au modèle pour supprimer l'emploi du temps
            if (EmploiDuTemps::delete($id)) {
                header('Location: index.php?action=index'); // Redirection après succès
                exit;
            } else {
                throw new Exception("Erreur lors de la suppression de l'emploi du temps.");
            }
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }
}
