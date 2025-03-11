<?php
require_once __DIR__ . '/../../db.php';

class EmploiDuTemps {
    // Récupérer tous les emplois du temps (avec pagination optionnelle)
    public static function getAll($limit = null, $offset = null) {
        $pdo = Database::connect(); // Utilisation de Database::connect()
        try {
            $sql = "SELECT * FROM emploi_du_temps";
            if ($limit !== null && $offset !== null) {
                $sql .= " LIMIT :limit OFFSET :offset";
            }
            $stmt = $pdo->prepare($sql);

            if ($limit !== null && $offset !== null) {
                $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération des emplois du temps : " . $e->getMessage());
        }
    }

    // Récupérer un emploi du temps par ID
    public static function getById($id) {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->prepare("SELECT * FROM emploi_du_temps WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération de l'emploi du temps : " . $e->getMessage());
        }
    }

    // Créer un nouvel emploi du temps
    public static function create($cours_id, $classe_id, $jour, $heure_debut, $heure_fin) {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->prepare("
            INSERT INTO emploi_du_temps (cours_id, classe_id, jour, heure_debut, heure_fin)
            VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([$cours_id, $classe_id, $jour, $heure_debut, $heure_fin]);
            // Validation des données
            if (empty($cours_id) || empty($classe_id) || empty($jour) || empty($heure_debut) || empty($heure_fin)) {
                throw new Exception("Tous les champs obligatoires doivent être remplis.");
            }

            $stmt = $pdo->prepare("INSERT INTO emploi_du_temps (cours_id, classe_id, jour, heure_debut, heure_fin) VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([$cours_id, $classe_id, $jour, $heure_debut, $heure_fin]);
        } catch (PDOException $e) {
            die("Erreur lors de la création de l'emploi du temps : " . $e->getMessage());
            throw new Exception("Erreur lors de la création de l'emploi du temps : " . $e->getMessage());
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    // Mettre à jour un emploi du temps
    public static function update($id, $cours_id, $classe_id, $jour, $heure_debut, $heure_fin) {
        $pdo = Database::connect();
        try {
            // Validation des données
            if (empty($cours_id) || empty($classe_id) || empty($jour) || empty($heure_debut) || empty($heure_fin)) {
                throw new Exception("Tous les champs obligatoires doivent être remplis.");
            }

            $stmt = $pdo->prepare("UPDATE emploi_du_temps SET cours_id = ?, classe_id = ?, jour = ?, heure_debut = ?, heure_fin = ? WHERE id = ?");
            return $stmt->execute([$cours_id, $classe_id, $jour, $heure_debut, $heure_fin, $id]);
        } catch (PDOException $e) {
            die("Erreur lors de la mise à jour de l'emploi du temps : " . $e->getMessage());
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    // Supprimer un emploi du temps
    public static function delete($id) {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->prepare("DELETE FROM emploi_du_temps WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            die("Erreur lors de la suppression de l'emploi du temps : " . $e->getMessage());
        }
    }

    // Rechercher des emplois du temps par jour
    public static function searchByDay($jour) {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->prepare("SELECT * FROM emploi_du_temps WHERE jour = ?");
            $stmt->execute([$jour]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la recherche des emplois du temps : " . $e->getMessage());
        }
    }

    // Compter le nombre total d'emplois du temps
    public static function count() {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM emploi_du_temps");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            die("Erreur lors du comptage des emplois du temps : " . $e->getMessage());
        }
    }
}
?>
