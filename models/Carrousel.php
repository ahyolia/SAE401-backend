<?php
namespace models;
require_once __DIR__ . '/../app/ModelInterface.php';
use app\ModelInterface;

class Carrousel extends \app\Model implements ModelInterface {
    public function __construct() {
        $this->table = "carrousel";
        parent::__construct();
    }

    /**
     * Récupère tous les éléments du carrousel
     * @return array
     */
    public function getAll(): array {
        $sql = "SELECT * FROM `{$this->table}`";
        $stmt = $this->getConnection()->prepare($sql);
        if (!$stmt) {
            \app\Debug::debugDie([$stmt->errno, $stmt->error]);
            return [];
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Récupère un élément du carrousel par son ID
     * @param int $id
     * @return array|bool
     */
    public function getById(int $id): array|bool {
        $sql = "SELECT * FROM `{$this->table}` WHERE `id` = ?";
        $stmt = $this->getConnection()->prepare($sql);
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
     * Crée un nouvel élément dans le carrousel
     * @param array $data
     * @return string
     */
    public function create(array $data): string {
        $sql = "INSERT INTO `{$this->table}` (`titre`, `image`, `description`, `categorie`) VALUES (?, ?, ?, ?)";
        $stmt = $this->getConnection()->prepare($sql);
        if (!$stmt) {
            \app\Debug::debugDie([$stmt->errno, $stmt->error]);
            return "Echec de la création : $sql";
        }
        $stmt->bind_param(
            "ssss",
            $data['titre'],
            $data['image'],
            $data['description'],
            $data['categorie']
        );
        if (!$stmt->execute()) {
            \app\Debug::debugDie([$stmt->errno, $stmt->error]);
            return "Echec de la création : $sql";
        }
        return "Création réussie";
    }

    /**
     * Met à jour un élément du carrousel
     * @param int $id
     * @param array $data
     * @return string
     */
    public function update(int $id, array $data): string {
        $sql = "UPDATE `{$this->table}` SET `titre` = ?, `image` = ?, `description` = ? WHERE `id` = ?";
        $stmt = $this->getConnection()->prepare($sql);
        if (!$stmt) {
            \app\Debug::debugDie([$stmt->errno, $stmt->error]);
            return "Echec de la mise à jour : $sql";
        }
        $stmt->bind_param("sssi", $data['titre'], $data['image'], $data['description'], $id);
        if (!$stmt->execute()) {
            \app\Debug::debugDie([$stmt->errno, $stmt->error]);
            return "Echec de la mise à jour : $sql";
        }
        return "Mise à jour réussie";
    }

    /**
     * Supprime un élément du carrousel
     * @param int $id
     * @return string
     */
    public function delete(int $id): string {
        $sql = "DELETE FROM `{$this->table}` WHERE `id` = ?";
        $stmt = $this->getConnection()->prepare($sql);
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

    /**
     * Récupère les éléments du carrousel par catégorie
     * @param string $categorie
     * @return array
     */
    public function getByCategorie($categorie): array {
        $sql = "SELECT * FROM `{$this->table}` WHERE categorie = ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_param("s", $categorie);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}