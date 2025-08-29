<?php
namespace controllers;

class Carrousel extends \app\Controller {
   

    /**
     * Affiche la liste des éléments du carrousel
     * @return void
     */
    
     // GET /api/carrousel
    public function Index(): void {
        $this->loadModel('Carrousel');
        $carrousel = $this->Carrousel->getAll();
        header('Content-Type: application/json');
        echo json_encode($carrousel);
    }

    /**
     * Crée un nouvel élément dans le carrousel
     * @return void
     */
    
    // POST /api/carrousel
    public function Create(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->loadModel('Carrousel');
            $data = json_decode(file_get_contents('php://input'), true);
            $success = $this->Carrousel->create($data);
            $msg = $success ? "Élément ajouté au carrousel." : "Erreur lors de l'ajout.";
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

    /**
     * Met à jour un élément du carrousel
     * @param int $id
     * @return void
     */
    // PUT /api/carrousel/{id}
    public function Update(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $this->loadModel('Carrousel');
            $data = json_decode(file_get_contents('php://input'), true);
            $success = $this->Carrousel->update($id, $data);
            $msg = $success ? "Élément du carrousel mis à jour." : "Erreur lors de la mise à jour.";
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

    /**
     * Supprime un élément du carrousel
     * @param int $id
     * @return void
     */
    // DELETE /api/carrousel/{id}
    public function Delete(int $id): void {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $this->loadModel('Carrousel');
            $success = $this->Carrousel->delete($id);
            $msg = $success ? "Élément supprimé du carrousel." : "Erreur lors de la suppression.";
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