<?php
require_once '../models/Etudiant.php'; // Inclusion du modèle Etudiant

class EtudiantController {
    // Afficher tous les étudiants (avec pagination et recherche)
    public function index() {
        $page = $_GET['page'] ?? 1; // Page actuelle (par défaut : 1)
        $limit = 10; // Nombre d'éléments par page
        $offset = ($page - 1) * $limit; // Calcul de l'offset

        $searchTerm = $_GET['search'] ?? ''; // Paramètre de recherche (facultatif)

        try {
            if (!empty($searchTerm)) {
                $etudiants = Etudiant::search($searchTerm); // Rechercher par nom ou email
                $total = count($etudiants); // Nombre de résultats de la recherche
            } else {
                $etudiants = Etudiant::getAll($limit, $offset); // Récupérer les étudiants avec pagination
                $total = Etudiant::count(); // Nombre total d'étudiants
            }

            $pages = ceil($total / $limit); // Calcul du nombre de pages

            // Charger la vue pour afficher les étudiants
            require '../views/etudiants/index.php';
        } catch (Exception $e) {
            die("Erreur lors de l'affichage des étudiants : " . $e->getMessage());
        }
    }

    // Afficher le formulaire de création d'un étudiant
    public function create() {
        try {
            require '../views/etudiants/create.php'; // Vue pour le formulaire de création
        } catch (Exception $e) {
            die("Erreur lors de l'affichage du formulaire de création : " . $e->getMessage());
        }
    }

    // Enregistrer un nouvel étudiant dans la base
    public function store() {
        $nom = $_POST['nom'] ?? null; // Récupère le nom depuis le formulaire
        $prenom = $_POST['prenom'] ?? null; // Récupère le prénom depuis le formulaire
        $email = $_POST['email'] ?? null; // Récupère l'email depuis le formulaire
        $classe_id = $_POST['classe_id'] ?? null; // Récupère l'identifiant de la classe

        try {
            // Appel au modèle pour créer un étudiant avec les nouveaux champs
            if (Etudiant::create($nom, $prenom, $email, $classe_id)) {
                header('Location: index.php?action=index'); // Redirection après succès
                exit;
            } else {
                throw new Exception("Erreur lors de la création de l'étudiant.");
            }
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    // Afficher le formulaire de modification d'un étudiant
    public function edit($id) {
        try {
            $etudiant = Etudiant::getById($id); // Récupérer les données de l'étudiant par son ID
            require '../views/etudiants/edit.php'; // Vue pour le formulaire de modification
        } catch (Exception $e) {
            die("Erreur lors de l'affichage du formulaire de modification : " . $e->getMessage());
        }
    }

    // Mettre à jour un étudiant existant
    public function update($id) {
        $nom = $_POST['nom'] ?? null; // Récupère le nom
        $prenom = $_POST['prenom'] ?? null; // Récupère le prénom
        $email = $_POST['email'] ?? null; // Récupère l'email
        $classe_id = $_POST['classe_id'] ?? null; // Récupère l'identifiant de la classe

        try {
            // Appel au modèle pour mettre à jour les données
            if (Etudiant::update($id, $nom, $prenom, $email, $classe_id)) {
                header('Location: index.php?action=index'); // Redirection après succès
                exit;
            } else {
                throw new Exception("Erreur lors de la mise à jour de l'étudiant.");
            }
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    // Supprimer un étudiant
    public function destroy($id) {
        try {
            // Appel au modèle pour supprimer l'étudiant
            if (Etudiant::delete($id)) {
                header('Location: index.php?action=index'); // Redirection après succès
                exit;
            } else {
                throw new Exception("Erreur lors de la suppression de l'étudiant.");
            }
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }
}
?>
