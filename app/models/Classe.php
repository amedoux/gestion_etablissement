<?php
require_once __DIR__ . '/../../db.php';

class Classe {
    // Récupérer toutes les classes
    public static function getAll() {
        $pdo = Database::connect(); // Utilise Database::connect() pour garantir la connexion
        try {
            

            $stmt = $pdo->query("SELECT id, nom, niveau FROM classes");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération des classes : " . $e->getMessage());
        }
    }

    // Récupérer une classe par ID
    public static function getById($id) {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->prepare("SELECT id, nom, niveau FROM classes WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération de la classe : " . $e->getMessage());
        }
    }

    // Créer une nouvelle classe
    public static function create($nom, $niveau) {
        $pdo = Database::connect(); // Utilise Database::connect() pour garantir la connexion
        try {
            $stmt = $pdo->prepare("INSERT INTO classes (nom, niveau) VALUES (?, ?)");
            return $stmt->execute([$nom, $niveau]);
        } catch (PDOException $e) {
            die("Erreur lors de la création de la classe : " . $e->getMessage());
        }
    }

    // Mettre à jour une classe
    public static function update($id, $nom, $niveau) {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->prepare("UPDATE classes SET nom = ?, niveau = ? WHERE id = ?");
            return $stmt->execute([$nom, $niveau, $id]);
        } catch (PDOException $e) {
            die("Erreur lors de la mise à jour de la classe : " . $e->getMessage());
        }
    }

    // Supprimer une classe
    public static function delete($id) {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->prepare("DELETE FROM classes WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            die("Erreur lors de la suppression de la classe : " . $e->getMessage());
        }
    }
}
?>
