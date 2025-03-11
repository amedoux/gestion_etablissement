<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../app/models/cours.php';
require_once __DIR__ . '/../db.php';

class CoursTest extends TestCase {

    // Préparation des données avant chaque test
    protected function setUp(): void {
        // Nettoyer la table cours pour chaque test (facultatif)
        $pdo = Database::connect();
        $pdo->exec("DELETE FROM cours");

        // Insérer un cours initial pour les tests
        Cours::create('Programmation Web', 'Introduction à la programmation web', 1);
    }

    // Test de la méthode create
    public function testCreateCours() {
        $result = Cours::create('Programmation Avancée', 'Cours avancé en programmation', 1);
        $this->assertTrue($result, "Échec lors de la création du cours.");

        // Vérifier l'insertion dans la base
        $cours = Cours::getAll();
        $this->assertCount(2, $cours, "Le cours n'a pas été ajouté correctement.");
    }

    // Test de la méthode getAll
    public function testGetAllCours() {
        $cours = Cours::getAll();
        $this->assertNotEmpty($cours, "La liste des cours est vide.");
        $this->assertIsArray($cours, "Le résultat n'est pas un tableau.");
    }

    // Test de la méthode getById
    public function testGetByIdCours() {
        // Récupération de l'ID du cours inséré
        $cours = Cours::getAll();
        $firstCours = reset($cours); // Obtenez le premier cours
        $retrievedCours = Cours::getById($firstCours['id']); // Récupérer le cours par ID

        $this->assertNotEmpty($retrievedCours, "Le cours n'a pas été trouvé.");
        $this->assertEquals('Programmation Web', $retrievedCours['nom'], "Le nom du cours ne correspond pas.");
    }

    // Test de la méthode update
    public function testUpdateCours() {
        // Récupération de l'ID du cours inséré
        $cours = Cours::getAll();
        $firstCours = reset($cours); // Obtenez le premier cours
        $result = Cours::update($firstCours['id'], 'Programmation Avancée', 'Cours avancé en programmation', 1);

        $this->assertTrue($result, "La mise à jour du cours a échoué.");

        // Vérifier la mise à jour
        $updatedCours = Cours::getById($firstCours['id']);
        $this->assertEquals('Programmation Avancée', $updatedCours['nom'], "Le nom du cours n'a pas été mis à jour.");
    }

    // Test de la méthode delete
    public function testDeleteCours() {
        // Récupération de l'ID du cours inséré
        $cours = Cours::getAll();
        $firstCours = reset($cours); // Obtenez le premier cours
        $result = Cours::delete($firstCours['id']);

        $this->assertTrue($result, "La suppression du cours a échoué.");

        // Vérifier que le cours a été supprimé
        $deletedCours = Cours::getById($firstCours['id']);
        $this->assertEmpty($deletedCours, "Le cours n'a pas été supprimé.");
    }

    // Test de la méthode search
    public function testSearchCours() {
        $cours = Cours::search('Programmation');
        $this->assertNotEmpty($cours, "Aucun cours correspondant à la recherche n'a été trouvé.");
        $this->assertEquals('Programmation Web', $cours[0]['nom'], "Le cours trouvé ne correspond pas.");
    }

    // Test de la méthode count
    public function testCountCours() {
        $total = Cours::count();
        $this->assertIsInt($total, "Le total des cours n'est pas un entier.");
        $this->assertEquals(1, $total, "Le total des cours est incorrect.");
    }
}
