<?php
namespace controllers;

use app\ModelFactory;

class Categories extends \app\Controller {
    protected $categoriesModel;

    public function __construct() {
        $this->categoriesModel = ModelFactory::create('Categories');
    }

    // GET /api/categories

    public function index($api = false): mixed {
        $categories = $this->categoriesModel->getAll();
        if ($api) {
            header('Content-Type: application/json');
            echo json_encode($categories);
            return null;
        }
        return $this->render('index', compact('categories'), $api);
    }

    // POST /api/categories

    public function create($api = false): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            if (empty($data)) {
                $data = json_decode(file_get_contents('php://input'), true);
            }
            try {
                $success = $this->categoriesModel->create($data);
                $msg = $success ? "Catégorie ajoutée." : "Erreur lors de l'ajout.";
                if ($api) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => $success,
                        'message' => $msg
                    ]);
                    return;
                }
                echo $msg;
            } catch (\Throwable $e) {
                if ($api) {
                    http_response_code(400);
                    echo json_encode([
                        'success' => false,
                        'message' => 'Erreur : ' . $e->getMessage()
                    ]);
                    return;
                }
                echo 'Erreur : ' . $e->getMessage();
            }
        } else {
            $this->render('create');
        }
    }

    // PUT /api/categories/{id}

    public function update(int $id, $api = false): void {
        $data = $_POST;
        if (empty($data)) {
            $data = json_decode(file_get_contents('php://input'), true);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $success = $this->categoriesModel->update($id, $data);
                $msg = $success ? "Catégorie mise à jour." : "Erreur lors de la mise à jour.";
                if ($api) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => $success,
                        'message' => $msg
                    ]);
                    return;
                }
                echo $msg;
            } catch (\Throwable $e) {
                if ($api) {
                    http_response_code(400);
                    echo json_encode([
                        'success' => false,
                        'message' => 'Erreur : ' . $e->getMessage()
                    ]);
                    return;
                }
                echo 'Erreur : ' . $e->getMessage();
            }
        } else {
            $categorie = $this->categoriesModel->getById($id);
            $this->render('update', compact('categorie'));
        }
    }

    // DELETE /api/categories/{id}

    public function delete(int $id, $api = false): void {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE' || $_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $success = $this->categoriesModel->delete($id);
                $msg = $success ? "Catégorie supprimée." : "Erreur lors de la suppression.";
                if ($api) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => $success,
                        'message' => $msg
                    ]);
                    return;
                }
                echo $msg;
            } catch (\Throwable $e) {
                if ($api) {
                    http_response_code(400);
                    echo json_encode([
                        'success' => false,
                        'message' => 'Erreur : ' . $e->getMessage()
                    ]);
                    return;
                }
                echo 'Erreur : ' . $e->getMessage();
            }
        } else {
            $categorie = $this->categoriesModel->getById($id);
            $this->render('delete', compact('categorie'));
        }
    }
}