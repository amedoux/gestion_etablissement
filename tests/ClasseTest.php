<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../app/models/Classe.php';
require_once __DIR__ . '/../db.php';

class ClasseTest extends TestCase {

    // Insérer des données avant chaque test
    protected function setUp(): void {
        // Suppression des données existantes pour assurer un environnement propre
        $pdo = Database::connect();
        $pdo->exec("DELETE FROM classes");

        // Insertion d'une classe de base pour les tests
        Classe::create('Mathématiques', 'Licence');
    }

    // Test de la méthode create
    public function testCreateClasse() {
        $result = Classe::create('Physique Fondamentale', 'Master');
        $this->assertTrue($result, "Échec lors de la création de la classe.");
        
        // Vérifier si la classe a été insérée
        $classes = Classe::getAll();
        $this->assertCount(2, $classes, "La classe n'a pas été ajoutée correctement.");
    }

    // Test de la méthode getAll
    public function testGetAllClasses() {
        $classes = Classe::getAll();
        $this->assertNotEmpty($classes, "La liste des classes est vide.");
        $this->assertIsArray($classes, "Le résultat n'est pas un tableau.");
    }

    // Test de la méthode getById
    public function testGetByIdClasse() {
        // Récupération de la première classe
        $classes = Classe::getAll();
        $firstClasse = reset($classes); // Obtenez la première classe par ID
        $classe = Classe::getById($firstClasse['id']); // Récupère la classe par ID

        $this->assertNotEmpty($classe, "La classe n'a pas été trouvée.");
        $this->assertEquals('Mathématiques', $classe['nom'], "Le nom de la classe ne correspond pas.");
    }

    // Test de la méthode update
    public function testUpdateClasse() {
        // Récupération de la première classe
        $classes = Classe::getAll();
        $firstClasse = reset($classes); // Obtenez la première classe
        $result = Classe::update($firstClasse['id'], 'Mathématiques Appliquées', 'Doctorat');

        $this->assertTrue($result, "La mise à jour de la classe a échoué.");

        // Vérifier que la classe a été mise à jour
        $updatedClasse = Classe::getById($firstClasse['id']);
        $this->assertEquals('Mathématiques Appliquées', $updatedClasse['nom'], "Le nom de la classe n'a pas été mis à jour.");
    }

    // Test de la méthode delete
    public function testDeleteClasse() {
        // Récupération de la première classe
        $classes = Classe::getAll();
        $firstClasse = reset($classes); // Obtenez la première classe
        $result = Classe::delete($firstClasse['id']);

        $this->assertTrue($result, "La suppression de la classe a échoué.");

        // Vérifier que la classe a été supprimée
        $deletedClasse = Classe::getById($firstClasse['id']);
        $this->assertEmpty($deletedClasse, "La classe n'a pas été supprimée.");
    }
}
