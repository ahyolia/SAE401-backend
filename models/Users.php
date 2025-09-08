<?php
namespace models;

require_once __DIR__ . '/../app/ModelInterface.php';
use app\ModelInterface;

class Users extends \app\Model implements ModelInterface {
    public function __construct() {
        // Nous définissons la table par défaut de ce modèle 
        $this->table = "users"; 
        
        parent::__construct(); 
    }

     // Inscription d'un nouvel utilisateur
    public function register($data) {
        $sql = "INSERT INTO users (email, password, role, numero_etudiant, nom, prenom, adherent, '')
                VALUES (?, ?, ?, ?, ?, ?, ?)";
            $emptyToken = '';
            $stmt = $this->getConnection()->prepare($sql);
            $hashed = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt->bind_param(
                "ssssssis",
                $data['email'],
                $hashed,
                $data['role'],
                $data['numero_etudiant'],
                $data['nom'],
                $data['prenom'],
                $data['adherent'],
                $emptyToken
            );
            return $stmt->execute();
    }

       // Trouver un utilisateur par email ou username (pour la connexion)
    public function findByLogin($login): array|bool {
        $sql = "SELECT * FROM `{$this->table}` WHERE email = ? OR prenom = ? LIMIT 1";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_param("ss", $login, $login);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ?: false;
    }

    
    public function updateProfile($id, $prenom, $email, $password = null): bool {
        if ($password) {
            $sql = "UPDATE `{$this->table}` SET prenom = ?, email = ?, password = ? WHERE id = ?";
            $stmt = $this->getConnection()->prepare($sql);
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param('sssi', $prenom, $email, $hash, $id);
        } else {
            $sql = "UPDATE `{$this->table}` SET prenom = ?, email = ? WHERE id = ?";
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bind_param("ssi", $prenom, $email, $id);
        }
        return $stmt && $stmt->execute();
    }

    public function isAdherent($userId): bool {
        $sql = "SELECT adherent FROM `{$this->table}` WHERE id = ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return !empty($row) && $row['adherent'] == 1;
    }

    public function setAdherent($userId) {
        $sql = "UPDATE users SET adherent = 1 WHERE id = ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_param("i", $userId);
        return $stmt->execute();
    }

    public function findById($id): array|bool {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->getConnection()->prepare($sql);
        if (!$stmt) return false;
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ?: false;
    }

    public function updateToken($email, $token) {
        $sql = "UPDATE `users` SET token = ? WHERE email = ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_param("ss", $token, $email);
        return $stmt->execute();
    }

    public function deleteAccount($id): bool {
    $sql = "DELETE FROM `{$this->table}` WHERE id = ?";
    $stmt = $this->getConnection()->prepare($sql);
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

}
?>
