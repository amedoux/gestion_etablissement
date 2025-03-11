<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../app/models/EmploiDuTemps.php';
require_once __DIR__ . '/../db.php';

class EmploiDuTempsTest extends TestCase {

    // Initialisation de données avant chaque test
    protected function setUp(): void {
        $pdo = Database::connect();

        // Supprimer toutes les données existantes pour garantir un état propre
        $pdo->exec("DELETE FROM emploi_du_temps");
        $pdo->exec("DELETE FROM cours");
        $pdo->exec("DELETE FROM classes");

        // Ajouter des données de base
        $pdo->exec("INSERT INTO cours (id, nom, description) VALUES (1, 'Programmation Web', 'Cours sur le développement web')");
        $pdo->exec("INSERT INTO classes (id, nom, niveau) VALUES (1, 'Informatique Licence 1', 'Licence')");

        // Ajouter un emploi du temps pour les tests
        EmploiDuTemps::create(1, 1, 'Lundi', '08:00:00', '10:00:00');
    }

    // Test de la méthode create
    public function testCreateEmploiDuTemps() {
        $result = EmploiDuTemps::create(1, 1, 'Mardi', '10:00:00', '12:00:00');
        $this->assertTrue($result, "Échec lors de la création de l'emploi du temps.");

        // Vérification dans la base
        $emplois = EmploiDuTemps::getAll();
        $this->assertCount(2, $emplois, "L'emploi du temps n'a pas été correctement ajouté.");
    }

    // Test de la méthode getAll
    public function testGetAllEmploisDuTemps() {
        $emplois = EmploiDuTemps::getAll();
        $this->assertNotEmpty($emplois, "La liste des emplois du temps est vide.");
        $this->assertIsArray($emplois, "Le résultat n'est pas un tableau.");
    }

    // Test de la méthode getById
    public function testGetByIdEmploiDuTemps() {
        $emplois = EmploiDuTemps::getAll();
        $firstEmploi = reset($emplois); // Récupération du premier emploi du temps
        $retrievedEmploi = EmploiDuTemps::getById($firstEmploi['id']);

        $this->assertNotEmpty($retrievedEmploi, "L'emploi du temps n'a pas été trouvé.");
        $this->assertEquals('Lundi', $retrievedEmploi['jour'], "Le jour de l'emploi du temps ne correspond pas.");
    }

    // Test de la méthode update
    public function testUpdateEmploiDuTemps() {
        $emplois = EmploiDuTemps::getAll();
        $firstEmploi = reset($emplois); // Récupération du premier emploi du temps

        $result = EmploiDuTemps::update($firstEmploi['id'], 1, 1, 'Mercredi', '14:00:00', '16:00:00');
        $this->assertTrue($result, "La mise à jour de l'emploi du temps a échoué.");

        // Vérification après mise à jour
        $updatedEmploi = EmploiDuTemps::getById($firstEmploi['id']);
        $this->assertEquals('Mercredi', $updatedEmploi['jour'], "Le jour de l'emploi du temps n'a pas été mis à jour.");
        $this->assertEquals('14:00:00', $updatedEmploi['heure_debut'], "L'heure de début n'a pas été mise à jour.");
    }

    // Test de la méthode delete
    public function testDeleteEmploiDuTemps() {
        $emplois = EmploiDuTemps::getAll();
        $firstEmploi = reset($emplois); // Récupération du premier emploi du temps

        $result = EmploiDuTemps::delete($firstEmploi['id']);
        $this->assertTrue($result, "La suppression de l'emploi du temps a échoué.");

        // Vérification après suppression
        $deletedEmploi = EmploiDuTemps::getById($firstEmploi['id']);
        $this->assertEmpty($deletedEmploi, "L'emploi du temps n'a pas été supprimé.");
    }

    // Test de la méthode searchByDay
    public function testSearchByDay() {
        $emplois = EmploiDuTemps::searchByDay('Lundi');
        $this->assertNotEmpty($emplois, "Aucun emploi du temps trouvé pour ce jour.");
        $this->assertEquals('Lundi', $emplois[0]['jour'], "Le jour de l'emploi du temps ne correspond pas.");
    }

    // Test de la méthode count
    public function testCountEmploiDuTemps() {
        $total = EmploiDuTemps::count();
        $this->assertIsInt($total, "Le total des emplois du temps n'est pas un entier.");
        $this->assertEquals(1, $total, "Le total des emplois du temps est incorrect.");
    }
}
