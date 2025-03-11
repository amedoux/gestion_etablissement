<?php
require_once __DIR__ . '/../../db.php';

class Prof {
    // Récupérer tous les professeurs (avec pagination optionnelle)
    public static function getAll($limit = null, $offset = null) {
        $pdo = Database::connect();
        try {
            $sql = "SELECT id, nom, prenom, email, specialite FROM profs";

            if ($limit !== null && $offset !== null) {
                $sql .= " LIMIT :limit OFFSET :offset";
            }
            $stmt = $pdo->prepare($sql);
    
            if ($limit !== null && $offset !== null) {
                $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
                $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            }
    
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération des professeurs : " . $e->getMessage());
        }
    }
    

    // Récupérer un professeur par ID
    public static function getById($id) {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->prepare("SELECT * FROM profs WHERE id = ?");
            $stmt->execute([(int)$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération du professeur : " . $e->getMessage());
        }
    }

    // Créer un nouveau professeur
    public static function create($nom, $prenom, $email, $specialite) {
        $pdo = Database::connect();
        try {
            // Validation des données
            if (empty($nom) || empty($prenom) || empty($email) || empty($specialite)) {
                throw new Exception("Tous les champs sont obligatoires.");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("L'adresse email n'est pas valide.");
            }
    
            // Vérification des doublons d'email
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM profs WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetchColumn() > 0) {
                throw new Exception("Cet email existe déjà dans la base de données.");
            }
    
            // Insertion du professeur avec le prénom
            $sql = "INSERT INTO profs (nom, prenom, email, specialite) VALUES (?, ?, ?, ?)";
            return $pdo->prepare($sql)->execute([$nom, $prenom, $email, $specialite]);
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la création du professeur : " . $e->getMessage());
        }
    }
    

    // Mettre à jour un professeur
    public static function update($id, $nom, $email, $specialite) {
        $pdo = Database::connect();
        try {
            // Validation des données
            if (empty($nom) || empty($email) || empty($specialite)) {
                throw new Exception("Le nom, l'email et la spécialité sont obligatoires.");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("L'adresse email n'est pas valide.");
            }

            $stmt = $pdo->prepare("UPDATE profs SET nom = ?, email = ?, specialite = ? WHERE id = ?");
            return $stmt->execute([$nom, $email, $specialite, (int)$id]);
        } catch (PDOException $e) {
            die("Erreur lors de la mise à jour du professeur : " . $e->getMessage());
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }

    // Supprimer un professeur
    public static function delete($id) {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->prepare("DELETE FROM profs WHERE id = ?");
            return $stmt->execute([(int)$id]);
        } catch (PDOException $e) {
            die("Erreur lors de la suppression du professeur : " . $e->getMessage());
        }
    }

    // Rechercher des professeurs par nom, email ou spécialité
    public static function search($searchTerm) {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->prepare("SELECT * FROM profs WHERE nom LIKE ? OR email LIKE ? OR specialite LIKE ?");
            $stmt->execute(['%' . $searchTerm . '%', '%' . $searchTerm . '%', '%' . $searchTerm . '%']);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la recherche des professeurs : " . $e->getMessage());
        }
    }

    // Compter le nombre total de professeurs
    public static function count() {
        $pdo = Database::connect();
        try {
            $stmt = $pdo->query("SELECT COUNT(*) as total FROM profs");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];
        } catch (PDOException $e) {
            die("Erreur lors du comptage des professeurs : " . $e->getMessage());
        }
    }
}
?>
