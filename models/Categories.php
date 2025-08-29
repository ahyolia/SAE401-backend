<?php
namespace models; 
class Categories extends \app\Model{ 
    
    public function __construct() {
        // Nous définissons la table par défaut de ce modèle 
        $this->table = "categories"; 
        
        // Nous ouvrons la connexion à la base de données 
        $this->getConnection(); 
    }

    public function getAll(): array {
        $sql = "SELECT * FROM `{$this->table}`";
        $stmt = $this->_connexion->prepare($sql);
        if (!$stmt) {
            \app\Debug::debugDie([$stmt->errno, $stmt->error]);
            return [];
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Récupère une catégorie par son ID
     * @param int $id
     * @return array|bool
     */
    public function getById(int $id): array|bool {
        $sql = "SELECT * FROM `{$this->table}` WHERE `id` = ?";
        $stmt = $this->_connexion->prepare($sql);
        if (!$stmt) {
            \app\Debug::debugDie([$stmt->errno, $stmt->error]);
            return false;
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Crée une nouvelle catégorie
     * @param array $data
     * @return string
     */
    public function create(array $data): string {
        $sql = "INSERT INTO `{$this->table}` (`name`) VALUES (?)";
        $stmt = $this->_connexion->prepare($sql);
        if (!$stmt) {
            \app\Debug::debugDie([$stmt->errno, $stmt->error]);
            return "Echec de la création : $sql";
        }
        $stmt->bind_param("s", $data['titre']);
        if (!$stmt->execute()) {
            \app\Debug::debugDie([$stmt->errno, $stmt->error]);
            return "Echec de la création : $sql";
        }
        return "Création réussie";
    }

    /**
     * Met à jour une catégorie
     * @param int $id
     * @param array $data
     * @return string
     */
    public function update(int $id, array $data): string {
        $sql = "UPDATE `{$this->table}` SET `name` = ? WHERE `id` = ?";
        $stmt = $this->_connexion->prepare($sql);
        if (!$stmt) {
            \app\Debug::debugDie([$stmt->errno, $stmt->error]);
            return "Echec de la mise à jour : $sql";
        }
        $stmt->bind_param("si", $data['titre'], $id);
        if (!$stmt->execute()) {
            \app\Debug::debugDie([$stmt->errno, $stmt->error]);
            return "Echec de la mise à jour : $sql";
        }
        return "Mise à jour réussie";
    }

    /**
     * Supprime une catégorie
     * @param int $id
     * @return string
     */
    public function delete(int $id): string {
        $sql = "DELETE FROM `{$this->table}` WHERE `id` = ?";
        $stmt = $this->_connexion->prepare($sql);
        if (!$stmt) {
            \app\Debug::debugDie([$stmt->errno, $stmt->error]);
            return "Echec de la suppression : $sql";
        }
        $stmt->bind_param("i", $id);
        if (!$stmt->execute()) {
            \app\Debug::debugDie([$stmt->errno, $stmt->error]);
            return "Echec de la suppression : $sql";
        }
        return "Suppression réussie";
    }

}
?>