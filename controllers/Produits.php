<?php
namespace controllers;

class Produits extends \app\Controller {

    public function getAll() {
        $sql = "SELECT * FROM produits";
        return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $sql = "SELECT * FROM produits WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO produits (name, description, stock, category_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['name'],
            $data['description'],
            $data['stock'],
            $data['category_id']
        ]);
        return "Produit ajouté avec succès.";
    }

    public function update($id, $data) {
        $sql = "UPDATE produits SET name = ?, description = ?, stock = ?, category_id = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $data['name'],
            $data['description'],
            $data['stock'],
            $data['category_id'],
            $id
        ]);
        return "Produit mis à jour.";
    }

    public function delete($id) {
        $sql = "DELETE FROM produits WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return "Produit supprimé.";
    }
}