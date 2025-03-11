<?php
require_once __DIR__ . '/../../db.php';

class Etudiant {
    // Récupérer tous les étudiants (avec pagination optionnelle)
    public static function getAll($limit = null, $offset = null) {
        $pdo = Database::connect(); // Connexion à la base de données
        try {
            $sql = "SELECT etudiants.id, etudiants.nom, etudiants.prenom, etudiants.email, classes.nom AS classe
                    FROM etudiants
                    LEFT JOIN classes ON etudiants.classe_id = classes.id";

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
            die("Erreur lors de la récupération des étudiants : " . $e->getMessage());
        }
    }

    public static function getById($id) {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->prepare("SELECT id, nom, prenom, email, classe_id FROM etudiants WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération de l'étudiant : " . $e->getMessage());
        }
    }
    
    

    // Créer un nouvel étudiant
    public static function create($nom, $prenom, $email, $classe_id) {
        $pdo = Database::connect();
        try {
            // Validation des données
            if (empty($nom)) {
                throw new Exception("Le champ 'nom' est obligatoire.");
            }
            if (empty($prenom)) {
                throw new Exception("Le champ 'prenom' est obligatoire.");
            }
            if (empty($email)) {
                throw new Exception("Le champ 'email' est obligatoire.");
            }
            if (empty($classe_id)) {
                throw new Exception("Le champ 'classe_id' est obligatoire.");
            }

            // Requête d'insertion
            $stmt = $pdo->prepare("
                INSERT INTO etudiants (nom, prenom, email, classe_id) 
                VALUES (?, ?, ?, ?)
            ");
            return $stmt->execute([$nom, $prenom, $email, $classe_id]);
        } catch (PDOException $e) {
            die("Erreur lors de la création de l'étudiant : " . $e->getMessage());
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    // Mettre à jour un étudiant existant
    public static function update($id, $nom, $prenom, $email, $classe_id) {
        $pdo = Database::connect();
        try {
            // Validation des données
            if (empty($nom)) {
                throw new Exception("Le champ 'nom' est obligatoire.");
            }
            if (empty($prenom)) {
                throw new Exception("Le champ 'prenom' est obligatoire.");
            }
            if (empty($email)) {
                throw new Exception("Le champ 'email' est obligatoire.");
            }
            if (empty($classe_id)) {
                throw new Exception("Le champ 'classe_id' est obligatoire.");
            }

            // Requête de mise à jour
            $stmt = $pdo->prepare("
                UPDATE etudiants 
                SET nom = ?, prenom = ?, email = ?, classe_id = ? 
                WHERE id = ?
            ");
            return $stmt->execute([$nom, $prenom, $email, $classe_id, $id]);
        } catch (PDOException $e) {
            die("Erreur lors de la mise à jour de l'étudiant : " . $e->getMessage());
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    // Supprimer un étudiant
    public static function delete($id) {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->prepare("DELETE FROM etudiants WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la suppression de l'étudiant : " . $e->getMessage());
        }
    }

    // Rechercher des étudiants par nom, prénom ou email
    public static function search($searchTerm) {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->prepare("
                SELECT etudiants.id, etudiants.nom, etudiants.prenom, etudiants.email, classes.nom AS classe
                FROM etudiants
                LEFT JOIN classes ON etudiants.classe_id = classes.id
                WHERE etudiants.nom LIKE ? OR etudiants.prenom LIKE ? OR etudiants.email LIKE ? OR classes.nom LIKE ?
            ");
            $stmt->execute(['%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la recherche des étudiants : " . $e->getMessage());
        }
    }

    // Compter le nombre total d'étudiants
    public static function count() {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM etudiants");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            die("Erreur lors du comptage des étudiants : " . $e->getMessage());
        }
    }
}
?>
