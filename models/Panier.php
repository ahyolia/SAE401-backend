<?php
namespace models;

class Panier extends \app\Model {
    public function __construct() {
        $this->table = "panier";
        parent::__construct();
    }

    public function getByUser($userId) {
        $sql = "SELECT produits FROM panier WHERE user_id = ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        error_log('Lecture panier BDD: ' . print_r($row, true));
        return $row ? json_decode($row['produits'], true) : [];
    }

    public function save($userId, $produits) {
        $json = json_encode($produits);
        $sql = "INSERT INTO panier (user_id, produits) VALUES (?, ?)
                ON DUPLICATE KEY UPDATE produits = ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_param("iss", $userId, $json, $json);
        return $stmt->execute();
    }

    public function update($userId, $produits) {
        $json = json_encode($produits);
        $sql = "UPDATE panier SET produits = ? WHERE user_id = ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_param("si", $json, $userId);
        return $stmt->execute();
    }

    public function delete($userId) {
        $sql = "DELETE FROM panier WHERE user_id = ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_param("i", $userId);
        return $stmt->execute();
    }

    public function addProduit($reservationId, $produitId, $quantite) {
        $sql = "INSERT INTO reservation_produits (reservation_id, produit_id, quantite) VALUES (?, ?, ?)";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_param("iii", $reservationId, $produitId, $quantite);
        $stmt->execute();
    }

    public function apiPost($api = false): void {
        $this->requireUser();
        $this->loadModel('Panier');
        $userId = $_SESSION['user']['id'];
        $data = json_decode(file_get_contents('php://input'), true);
        error_log('Panier reçu: ' . json_encode($data));
        $success = $this->Panier->save($userId, $data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function decrementStock($id, $quantity) {
        $sql = "UPDATE produits SET stock = stock - ? WHERE id = ? AND stock >= ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_param("iii", $quantity, $id, $quantity);
        $stmt->execute();
    }
}