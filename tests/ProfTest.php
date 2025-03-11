<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../app/models/Prof.php';
require_once __DIR__ . '/../db.php';

class ProfTest extends TestCase {

    // Préparer un environnement propre avant chaque test
    protected function setUp(): void {
        $pdo = Database::connect();

        // Supprime les données existantes pour un environnement propre
        $pdo->exec("DELETE FROM profs");

        // Ajouter un professeur de base pour les tests
        Prof::create('Dupont', 'Jean', 'jean.dupont@example.com', 'Mathématiques');
    }

    // Test de la méthode create
    public function testCreateProf() {
        $result = Prof::create('Durand', 'Marie', 'marie.durand@example.com', 'Physique');
        $this->assertTrue($result, "Échec lors de la création du professeur.");

        // Vérifier que le professeur a été ajouté
        $profs = Prof::getAll();
        $this->assertCount(2, $profs, "Le professeur n'a pas été ajouté correctement.");
    }

    // Test de la méthode getAll
    public function testGetAllProfs() {
        $profs = Prof::getAll();
        $this->assertNotEmpty($profs, "La liste des professeurs est vide.");
        $this->assertIsArray($profs, "Le résultat n'est pas un tableau.");
    }

    // Test de la méthode getById
    public function testGetByIdProf() {
        $profs = Prof::getAll();
        $firstProf = reset($profs); // Récupération du premier professeur
        $retrievedProf = Prof::getById($firstProf['id']);

        $this->assertNotEmpty($retrievedProf, "Le professeur n'a pas été trouvé.");
        $this->assertEquals('Dupont', $retrievedProf['nom'], "Le nom du professeur ne correspond pas.");
    }

    // Test de la méthode update
    public function testUpdateProf() {
        $profs = Prof::getAll();
        $firstProf = reset($profs); // Récupération du premier professeur

        $result = Prof::update($firstProf['id'], 'Dupont', 'dupont.john@example.com', 'Informatique');
        $this->assertTrue($result, "La mise à jour du professeur a échoué.");

        // Vérifier les modifications
        $updatedProf = Prof::getById($firstProf['id']);
        $this->assertEquals('dupont.john@example.com', $updatedProf['email'], "L'email du professeur n'a pas été mis à jour.");
        $this->assertEquals('Informatique', $updatedProf['specialite'], "La spécialité du professeur n'a pas été mise à jour.");
    }

    // Test de la méthode delete
    public function testDeleteProf() {
        $profs = Prof::getAll();
        $firstProf = reset($profs); // Récupération du premier professeur

        $result = Prof::delete($firstProf['id']);
        $this->assertTrue($result, "La suppression du professeur a échoué.");

        // Vérifier après suppression
        $deletedProf = Prof::getById($firstProf['id']);
        $this->assertEmpty($deletedProf, "Le professeur n'a pas été supprimé.");
    }

    // Test de la méthode search
    public function testSearchProf() {
        $profs = Prof::search('Dupont');
        $this->assertNotEmpty($profs, "Aucun professeur correspondant à la recherche n'a été trouvé.");
        $this->assertEquals('Dupont', $profs[0]['nom'], "Le professeur trouvé ne correspond pas.");
    }

    // Test de la méthode count
    public function testCountProfs() {
        $total = Prof::count();
        $this->assertIsInt($total, "Le total des professeurs n'est pas un entier.");
        $this->assertEquals(1, $total, "Le total des professeurs est incorrect.");
    }
}
