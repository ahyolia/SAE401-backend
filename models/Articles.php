<?php
namespace models;
require_once __DIR__ . '/../app/ModelInterface.php';
use app\ModelInterface;

class Articles extends \app\Model implements ModelInterface {
    public function __construct() {
        $this->table = "articles";
        parent::__construct();
    }

/**
* Retourne un article en fonction de son slug
* @param string $slug
* @return array|bool */

public function findBySlug(string $slug): array|bool {
    $sql = "SELECT * FROM ".$this->table." WHERE `slug`=?";
    $stmt = $this->getConnection()->prepare($sql);
    
    if(!$stmt) {
    \app\Debug::debugDie(array($stmt->errno,$stmt->error)); return false;
    }

    $stmt->bind_param("s", $slug);

    if(!$stmt->execute()) {
    \app\Debug::debugDie(array($stmt->errno,$stmt->error)); return false;
    }

    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

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

// Partie BackOffice  

/**  
 * * Met à jour un article en fonction de son ID  *
 * @param int $id 
 * @return string  
 */  
public function update(int $id, array $data): string {
    $sql = "UPDATE `{$this->table}` SET `titre` = ?, `contenu` = ?, `slug` = ?, `date_publication` = ?, `image` = ?, `is_main` = ? WHERE `id_article` = ?";
    $stmt = $this->getConnection()->prepare($sql);
    if (!$stmt) {
        \app\Debug::debugDie([$stmt->errno, $stmt->error]);
        return "Erreur lors de la mise à jour.";
    }
    $is_main = !empty($data['is_main']) ? 1 : 0;
    $stmt->bind_param(
        "ssssssi",
        $data['titre'],
        $data['contenu'],
        $data['slug'],
        $data['date_publication'],
        $data['image'],
        $is_main,
        $id
    );
    if ($stmt->execute()) {
        return "Mise à jour réussie";
    } else {
        return "Erreur lors de la mise à jour.";
    }
}

/**
 * Créer un nouvel article
 * @param array $data
 * @return string
 */

public function create(array $data): string {
    $sql = "INSERT INTO `{$this->table}` (`titre`, `contenu`, `slug`, `date_publication`, `image`, `is_main`) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->getConnection()->prepare($sql);
    if (!$stmt) {
        \app\Debug::debugDie([$stmt->errno, $stmt->error]);
        return "Echec de la création : $sql";
    }
    $is_main = !empty($data['is_main']) ? 1 : 0;
    $stmt->bind_param(
        "sssssi",
        $data['titre'],
        $data['contenu'],
        $data['slug'],
        $data['date_publication'],
        $data['image'],
        $is_main
    );
    if (!$stmt->execute()) {
        \app\Debug::debugDie([$stmt->errno, $stmt->error]);
        return "Echec de la création : $sql";
    }
    return "Création réussie";
}

/**
 * Supprime un article en fonction de son ID
 * @param int $id
 * @return string
 */
public function delete(int $id): string {
    $sql = "DELETE FROM `{$this->table}` WHERE `id_article` = ?";
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

public function getById($id): ?array {
    $sql = "SELECT * FROM `{$this->table}` WHERE id_article = ?";
    $stmt = $this->getConnection()->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc() ?: null;
}

}  
?>