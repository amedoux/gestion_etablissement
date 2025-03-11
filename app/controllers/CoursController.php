<?php
require_once '../models/Cours.php'; // Inclusion du modèle Cours

class CoursController {
    // Afficher tous les cours (avec pagination optionnelle)
    public function index() {
        $page = $_GET['page'] ?? 1; // Page actuelle (par défaut : 1)
        $limit = 10; // Nombre d'éléments par page
        $offset = ($page - 1) * $limit; // Calcul de l'offset

        $searchTerm = $_GET['search'] ?? ''; // Terme de recherche facultatif
        if (!empty($searchTerm)) {
            $cours = Cours::search($searchTerm); // Rechercher des cours
        } else {
            $cours = Cours::getAll($limit, $offset); // Récupérer tous les cours
        }

        $total = Cours::count(); // Nombre total de cours
        $pages = ceil($total / $limit); // Calcul du nombre total de pages

        // Charger la vue pour afficher les cours
        require '../views/cours/index.php';
    }

    // Afficher le formulaire de création de cours
    public function create() {
        require '../views/cours/create.php';
    }

    // Enregistrer un nouveau cours dans la base
    public function store() {
        $nom = $_POST['nom'];
        $description = $_POST['description'];
        $prof_id = $_POST['prof_id'];

        try {
            // Appel au modèle pour créer un cours
            if (Cours::create($nom, $description, $prof_id)) {
                header('Location: index.php?action=index'); // Redirection après succès
                exit;
            } else {
                throw new Exception("Erreur lors de la création du cours.");
            }
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    // Afficher le formulaire pour modifier un cours
    public function edit($id) {
        $cours = Cours::getById($id); // Récupérer les données du cours par son ID
        require '../views/cours/edit.php';
    }

    // Mettre à jour un cours existant
    public function update($id) {
        $nom = $_POST['nom'];
        $description = $_POST['description'];
        $prof_id = $_POST['prof_id'];

        try {
            // Appel au modèle pour mettre à jour le cours
            if (Cours::update($id, $nom, $description, $prof_id)) {
                header('Location: index.php?action=index'); // Redirection après succès
                exit;
            } else {
                throw new Exception("Erreur lors de la mise à jour du cours.");
            }
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    // Supprimer un cours
    public function destroy($id) {
        try {
            // Appel au modèle pour supprimer le cours
            if (Cours::delete($id)) {
                header('Location: index.php?action=index'); // Redirection après succès
                exit;
            } else {
                throw new Exception("Erreur lors de la suppression du cours.");
            }
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }
}
