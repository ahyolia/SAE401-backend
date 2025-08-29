<?php
namespace controllers;

class Categories extends \app\Controller {

    // GET /api/categories
    public function Index(): void {
        $this->loadModel('Categories');
        $categories = $this->Categories->getAll();
        header('Content-Type: application/json');
        echo json_encode($categories);
    }

    // POST /api/categories
    public function Create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->loadModel('Categories');
            $data = json_decode(file_get_contents('php://input'), true);
            $success = $this->Categories->create($data);
            $msg = $success ? "Catégorie ajoutée." : "Erreur lors de l'ajout.";
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $success,
                'message' => $msg
            ]);
        } else {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Méthode non autorisée']);
        }
    }

    // PUT /api/categories/{id}
    public function Update(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $this->loadModel('Categories');
            $data = json_decode(file_get_contents('php://input'), true);
            $success = $this->Categories->update($id, $data);
            $msg = $success ? "Catégorie mise à jour." : "Erreur lors de la mise à jour.";
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $success,
                'message' => $msg
            ]);
        } else {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Méthode non autorisée']);
        }
    }

    // DELETE /api/categories/{id}
    public function Delete(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $this->loadModel('Categories');
            $success = $this->Categories->delete($id);
            $msg = $success ? "Catégorie supprimée." : "Erreur lors de la suppression.";
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $success,
                'message' => $msg
            ]);
        } else {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Méthode non autorisée']);
        }
    }
}