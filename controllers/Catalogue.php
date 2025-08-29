<?php
namespace controllers;

class Catalogue extends \app\Controller {
    // GET /api/catalogue
    public function Index(): void {
        $this->loadModel('Produits');
        $this->loadModel('Categories');
        $produits = $this->Produits->getAll();
        $categories = $this->Categories->getAll();
        $data = [
            'produits' => $produits,
            'categories' => $categories,
            'activeCategory' => 'all'
        ];
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    // GET /api/catalogue/categories/{id}
    public function Categories($id): void {
        $this->loadModel('Produits');
        $this->loadModel('Categories');
        $produits = $this->Produits->getByCategory($id);
        $categories = $this->Categories->getAll();
        $data = [
            'produits' => $produits,
            'categories' => $categories,
            'activeCategory' => $id
        ];
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
}
?>