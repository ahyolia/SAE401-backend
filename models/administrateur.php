<?php
namespace models;
use app\ModelInterface;

class administrateur extends \app\Model implements ModelInterface {

public function __construct() {
    $this->table = "administrateur";
    parent::__construct();
}

/**
* Contrôle de la connexion
*
* @return string
*/

public function connexion(string $log, string $mdp): bool {
    $sql = "SELECT * FROM `{$this->table}` WHERE `login`=?";
    $stmt = $this->getConnection()->prepare($sql);
    if(!$stmt) {
        \app\Debug::debugDie(array($stmt->errno,$stmt->error));
        return false;
    }
    $stmt->bind_param("s", $log);
    if(!$stmt->execute()) {
        \app\Debug::debugDie(array($stmt->errno,$stmt->error));
        return false;
    }
    $result = $stmt->get_result();
    $administrateur = $result->fetch_assoc();
    return $administrateur && password_verify($mdp, $administrateur['mdp']);
}

    /**
     * Crée un nouvel administrateur
     * @param array $data
     * @return string
     */
    public function create(array $data): string {
        $sql = "INSERT INTO `{$this->table}` (`login`, `mdp`) VALUES (?, ?)";
        $stmt = $this->getConnection()->prepare($sql);
        if (!$stmt) {
            \app\Debug::debugDie([$stmt->errno, $stmt->error]);
            return "Echec de la création : $sql";
        }
        // Hash du mot de passe avant insertion
        $hashedPassword = password_hash($data['mdp'], PASSWORD_DEFAULT);
        $stmt->bind_param("ss", $data['login'], $hashedPassword);
        if (!$stmt->execute()) {
            \app\Debug::debugDie([$stmt->errno, $stmt->error]);
            return "Echec de la création : $sql";
        }
        return "Création réussie";
    }

    
    /**
     * Met à jour un administrateur en fonction de son ID
     * @param int $id
     * @param array $data
     * @return string
     */
    public function update(int $id, array $data): string {
        $sql = "UPDATE `{$this->table}` SET `login` = ?, `mdp` = ? WHERE `id` = ?";
        $stmt = $this->getConnection()->prepare($sql);
        if (!$stmt) {
            \app\Debug::debugDie([$stmt->errno, $stmt->error]);
            return "Echec de la mise à jour : $sql";
        }
        // Hash du mot de passe avant mise à jour
        $hashedPassword = password_hash($data['mdp'], PASSWORD_DEFAULT);
        $stmt->bind_param("ssi", $data['login'], $hashedPassword, $id);
        if (!$stmt->execute()) {
            \app\Debug::debugDie([$stmt->errno, $stmt->error]);
            return "Echec de la mise à jour : $sql";
        }
        return "Mise à jour réussie";
    }

    /**
     * Supprime un administrateur en fonction de son ID
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
}
?>
