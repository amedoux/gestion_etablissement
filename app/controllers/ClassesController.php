<?php
require_once '../models/Classe.php'; // Inclusion du modèle

class ClasseController {
    // Afficher toutes les classes
    public function index() {
        $classes = Classe::getAll(); // Récupérer toutes les classes via le modèle
        require '../views/classes/index.php'; // Charger la vue pour les afficher
    }

    // Afficher le formulaire de création
    public function create() {
        require '../views/classes/create.php'; // Charger la vue de création
    }

    // Enregistrer une nouvelle classe
    public function store() {
        $nom = $_POST['nom'];
        $niveau = $_POST['niveau'];
        Classe::create($nom, $niveau); // Appeler le modèle pour créer une classe
        header('Location: index.php'); // Redirection après création
    }

    // Afficher le formulaire de mise à jour
    public function edit($id) {
        $class = Classe::getById($id); // Récupérer une classe par ID
        require '../views/classes/edit.php'; // Charger la vue de mise à jour
    }

    // Mettre à jour une classe
    public function update($id) {
        $nom = $_POST['nom'];
        $niveau = $_POST['niveau'];
        Classe::update($id, $nom, $niveau); // Appeler le modèle pour mettre à jour la classe
        header('Location: index.php'); // Redirection après mise à jour
    }

    // Supprimer une classe
    public function destroy($id) {
        Classe::delete($id); // Supprimer une classe via le modèle
        header('Location: index.php'); // Redirection après suppression
    }
}
?>
