<?php
require_once __DIR__ . '/../../db.php';

class Cours {
    // Récupérer tous les cours (avec possibilité de pagination)
    public static function getAll($limit = null, $offset = null) {
        $pdo = Database::connect();
        try {
            $sql = "SELECT * FROM cours";
            if ($limit !== null && $offset !== null) {
                $sql .= " LIMIT :limit OFFSET :offset";
            }
            $stmt = $pdo->prepare($sql);

            $sql = "
            SELECT cours.id, cours.nom, cours.description, profs.nom AS prof_nom, profs.prenom AS prof_prenom
            FROM cours
            LEFT JOIN profs ON cours.prof_id = profs.id
        ";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($limit !== null && $offset !== null) {
                // Validation des limites pour éviter les attaques potentielles
                $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération des cours : " . $e->getMessage());
        }
    }

    // Récupérer un cours par ID
    public static function getById($id) {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->prepare("SELECT * FROM cours WHERE id = ?");
            $stmt->execute([(int)$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération du cours : " . $e->getMessage());
        }
    }

    // Créer un nouveau cours
    public static function create($nom, $description, $prof_id) {
        $pdo = Database::connect();
        try {
            // Validation des données
            if (empty($nom) || empty($prof_id)) {
                throw new Exception("Le nom du cours et l'ID du professeur sont requis.");
            }

            $stmt = $pdo->prepare("INSERT INTO cours (nom, description, prof_id) VALUES (?, ?, ?)");
            return $stmt->execute([$nom, $description, $prof_id]);
        } catch (PDOException $e) {
            die("Erreur lors de la création du cours : " . $e->getMessage());
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    // Mettre à jour un cours
    public static function update($id, $nom, $description, $prof_id) {
        $pdo = Database::connect();
        try {
            if (empty($nom) || empty($prof_id)) {
                throw new Exception("Le nom du cours et l'ID du professeur sont requis.");
            }

            $stmt = $pdo->prepare("UPDATE cours SET nom = ?, description = ?, prof_id = ? WHERE id = ?");
            return $stmt->execute([$nom, $description, $prof_id, (int)$id]);
        } catch (PDOException $e) {
            die("Erreur lors de la mise à jour du cours : " . $e->getMessage());
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    // Supprimer un cours
    public static function delete($id) {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->prepare("DELETE FROM cours WHERE id = ?");
            return $stmt->execute([(int)$id]);
        } catch (PDOException $e) {
            die("Erreur lors de la suppression du cours : " . $e->getMessage());
        }
    }

    // Rechercher des cours par nom
    public static function search($searchTerm) {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->prepare("SELECT * FROM cours WHERE nom LIKE ?");
            $stmt->execute(['%' . $searchTerm . '%']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la recherche des cours : " . $e->getMessage());
        }
    }

    // Compter le nombre total de cours (pour la pagination)
    public static function count() {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM cours");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            die("Erreur lors du comptage des cours : " . $e->getMessage());
        }
    }
}
?>
