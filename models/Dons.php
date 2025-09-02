<?php
namespace models;

class Dons extends \app\Model {
    public string $table = "dons";

    public function getById($id) {
        $sql = "SELECT * FROM dons WHERE id = ?";
        $stmt = $this->_connexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function add($data) {
        $sql = "INSERT INTO dons (user_id, produit, quantite, categorie_id, date_don) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->_connexion->prepare($sql);
        $stmt->bind_param("isiss", $data['user_id'], $data['produit'], $data['quantite'], $data['categorie_id'], $data['date_don']);
        return $stmt->execute();
    }

    public function getNonValides() {
        $sql = "SELECT * FROM dons WHERE valide = 0";
        $stmt = $this->_connexion->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function valider($id) {
        $sql = "UPDATE dons SET valide = 1 WHERE id = ?";
        $stmt = $this->_connexion->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $sql = "DELETE FROM dons WHERE id = ?";
        $stmt = $this->_connexion->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getByUserId($userId) {
        $sql = "SELECT * FROM dons WHERE user_id = ? ORDER BY date_don DESC";
        $stmt = $this->_connexion->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}