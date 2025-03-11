<?php
require_once '../models/Prof.php'; // Inclusion du modèle Prof

class ProfController {
    // Afficher tous les professeurs (avec pagination et recherche)
    public function index() {
        $page = $_GET['page'] ?? 1; // Page actuelle par défaut : 1
        $limit = 10; // Nombre de professeurs par page
        $offset = ($page - 1) * $limit; // Calcul de l'offset

        $searchTerm = $_GET['search'] ?? ''; // Recherche par nom, email ou spécialité

        if (!empty($searchTerm)) {
            $profs = Prof::search($searchTerm); // Recherche par critère
        } else {
            $profs = Prof::getAll($limit, $offset); // Récupérer tous les professeurs paginés
        }

        $total = Prof::count(); // Nombre total de professeurs
        $pages = ceil($total / $limit); // Calcul du nombre total de pages

        // Charger la vue pour afficher les professeurs
        require '../views/profs/index.php';
    }

    // Afficher le formulaire de création de professeur
    public function create() {
        require '../views/profs/create.php'; // Vue du formulaire de création
    }

    // Enregistrer un nouveau professeur
    public function store() {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom']; // Récupération du prénom
        $email = $_POST['email'];
        $specialite = $_POST['specialite'];
    
        try {
            // Appel au modèle pour créer un professeur avec le prénom
            if (Prof::create($nom, $prenom, $email, $specialite)) {
                header('Location: index.php?action=index'); // Redirection après succès
                exit;
            } else {
                throw new Exception("Erreur lors de la création du professeur.");
            }
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }
    

    // Afficher le formulaire de modification d'un professeur
    public function edit($id) {
        $prof = Prof::getById($id); // Récupérer les données du professeur par son ID
        require '../views/profs/edit.php'; // Vue pour le formulaire de modification
    }

    // Mettre à jour un professeur existant
    public function update($id) {
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $specialite = $_POST['specialite'];

        try {
            // Appel au modèle pour mettre à jour le professeur
            if (Prof::update($id, $nom, $email, $specialite)) {
                header('Location: index.php?action=index'); // Redirection après succès
                exit;
            } else {
                throw new Exception("Erreur lors de la mise à jour du professeur.");
            }
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    // Supprimer un professeur
    public function destroy($id) {
        try {
            // Appel au modèle pour supprimer un professeur
            if (Prof::delete($id)) {
                header('Location: index.php?action=index'); // Redirection après succès
                exit;
            } else {
                throw new Exception("Erreur lors de la suppression du professeur.");
            }
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }
}
