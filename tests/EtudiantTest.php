<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../app/models/Etudiant.php';
require_once __DIR__ . '/../db.php';
class EtudiantTest extends TestCase {
    protected function setUp(): void {
        // Nettoyage ou réinitialisation de la base de données avant chaque test
        $pdo = Database::connect();
        
        // Supprimer les étudiants de test existants
        $pdo->exec("DELETE FROM etudiants WHERE email LIKE 'test_%@example.com'");
        
        // Supprimer les classes de test et réinsérer une classe valide pour les tests
        $pdo->exec("DELETE FROM classes WHERE id >= 10");
        $pdo->exec("INSERT INTO classes (id, nom, niveau) VALUES (10, 'Classe Test', 'Licence') ON DUPLICATE KEY UPDATE nom = 'Classe Test', niveau = 'Licence'");
    }

    public function testCreateEtudiant(): void {
        $result = Etudiant::create("TestNom", "TestPrenom", "test_1@example.com", 10);
        $this->assertTrue($result, "La création de l'étudiant a échoué.");
    }

    public function testGetById(): void {
        // Crée un étudiant pour le récupérer
        Etudiant::create("TestNom", "TestPrenom", "test_2@example.com", 10);

        // Récupère l'étudiant par son ID
        $pdo = Database::connect();
        $id = $pdo->lastInsertId();
        $etudiant = Etudiant::getById($id);

        $this->assertNotEmpty($etudiant, "L'étudiant avec l'ID $id n'a pas été trouvé.");
        $this->assertEquals("TestNom", $etudiant['nom']);
        $this->assertEquals("TestPrenom", $etudiant['prenom']);
        $this->assertEquals("test_2@example.com", $etudiant['email']);
        $this->assertEquals(10, $etudiant['classe_id']);
    }

    public function testUpdateEtudiant(): void {
        // Crée un étudiant pour le mettre à jour
        Etudiant::create("AncienNom", "AncienPrenom", "test_3@example.com", 10);

        // Récupère l'ID de l'étudiant
        $pdo = Database::connect();
        $id = $pdo->lastInsertId();

        // Met à jour l'étudiant
        $result = Etudiant::update($id, "NouveauNom", "NouveauPrenom", "test_3_updated@example.com", 10);
        $this->assertTrue($result, "La mise à jour de l'étudiant a échoué.");

        // Vérifie les modifications
        $etudiant = Etudiant::getById($id);
        $this->assertEquals("NouveauNom", $etudiant['nom']);
        $this->assertEquals("NouveauPrenom", $etudiant['prenom']);
        $this->assertEquals("test_3_updated@example.com", $etudiant['email']);
        $this->assertEquals(10, $etudiant['classe_id']);
    }

    public function testDeleteEtudiant(): void {
        // Crée un étudiant pour le supprimer
        Etudiant::create("TestNom", "TestPrenom", "test_4@example.com", 10);

        // Récupère l'ID de l'étudiant
        $pdo = Database::connect();
        $id = $pdo->lastInsertId();

        // Supprime l'étudiant
        $result = Etudiant::delete($id);
        $this->assertTrue($result, "La suppression de l'étudiant a échoué.");

        // Vérifie que l'étudiant n'existe plus
        $etudiant = Etudiant::getById($id);
        $this->assertEmpty($etudiant, "L'étudiant avec l'ID $id n'a pas été supprimé.");
    }

    public function testSearchEtudiant(): void {
        // Crée plusieurs étudiants pour les recherches
        Etudiant::create("Alpha", "Beta", "test_5@example.com", 10);
        Etudiant::create("Gamma", "Delta", "test_6@example.com", 10);

        // Rechercher un étudiant par nom
        $results = Etudiant::search("Alpha");
        $this->assertNotEmpty($results, "Aucun résultat trouvé pour la recherche.");
        $this->assertEquals("Alpha", $results[0]['nom']);
    }
}
