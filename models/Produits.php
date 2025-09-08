<?php
namespace models;
use app\ModelInterface;

class Produits extends \app\Model implements ModelInterface {
    public function __construct() {
        $this->table = "produits";
        parent::__construct();
    }
    
    // Récupérer tous les produits
    public function getAll(): array {
        $sql = "SELECT p.*, c.name AS category_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Récupérer un produit par son ID
    public function getById($id): ?array {
        $sql = "SELECT * FROM `{$this->table}` WHERE id = ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }
    
    public function getByName($name) {
        $sql = "SELECT * FROM `{$this->table}` WHERE name = ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc() ?: null;
    }
    
    // Récupérer tous les produits d'une catégorie
    public function getByCategory($categoryId): array {
        $sql = "SELECT p.*, c.name AS category_name
                FROM {$this->table} p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.category_id = ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    // Ajouter un produit avec vérification d'existence
    public function create($name, $description, $stock, $categoryId): string {
        // Vérifie si le produit existe déjà (par le nom)
        $sqlCheck = "SELECT id FROM `{$this->table}` WHERE name = ?";
        $stmtCheck = $this->getConnection()->prepare($sqlCheck);
        $stmtCheck->bind_param("s", $name);
        $stmtCheck->execute();
        $stmtCheck->store_result();
        if ($stmtCheck->num_rows > 0) {
            return "Un produit avec ce nom existe déjà.";
        }

        // Ajout si non existant
        $sql = "INSERT INTO `{$this->table}` (name, description, stock, category_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_param("ssdi", $name, $description, $stock, $categoryId);
        if ($stmt->execute()) {
            return "Produit ajouté avec succès.";
        } else {
            return "Erreur lors de l'ajout du produit.";
        }
    }
    
    // Mettre à jour un produit
    public function update($id, $name, $description, $stock, $category_id, $image = null) {
        if ($image !== null) {
            $sql = "UPDATE `produits` SET name = ?, description = ?, stock = ?, category_id = ?, image = ? WHERE id = ?";
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bind_param("ssissi", $name, $description, $stock, $category_id, $image, $id);
        } else {
            $sql = "UPDATE `produits` SET name = ?, description = ?, stock = ?, category_id = ? WHERE id = ?";
            $stmt = $this->getConnection()->prepare($sql);
            $stmt->bind_param("ssisi", $name, $description, $stock, $category_id, $id);
        }
        if (!$stmt->execute()) {
            \app\Debug::debugDie([$stmt->errno, $stmt->error]);
            return "Echec de la mise à jour : $sql";
        }
        return "Mise à jour réussie";
    }
    
    // Supprimer un produit
    public function delete($id): string {
        $sql = "DELETE FROM `{$this->table}` WHERE id = ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return "Suppression réussie.";
        } else {
            return "Erreur lors de la suppression du produit.";
        }
    }
    
    // Décrémenter le stock d'un produit
    public function decrementStock($id, $quantity) {
        $sql = "UPDATE {$this->table} SET stock = stock - ? WHERE id = ? AND stock >= ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_param("iii", $quantity, $id, $quantity);
        $stmt->execute();
    }
}