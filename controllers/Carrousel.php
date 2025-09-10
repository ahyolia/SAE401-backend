<?php
namespace controllers;

require_once __DIR__ . '/../app/ModelFactory.php';
use app\ModelFactory;


class Carrousel extends \app\Controller {
    protected $carrouselModel;

    public function __construct() {
        $this->carrouselModel = ModelFactory::create('Carrousel');
    }

    /**
     * Affiche la liste des éléments du carrousel
     * @return void
     */
    
     // GET /api/carrousel

    public function index($api = false) {
        $this->loadModel('Carrousel');
        $carrouselPartenaires = $this->Carrousel->getAll();
        if ($api) {
            foreach ($carrouselPartenaires as &$p) {
                if (!empty($p['image']) && strpos($p['image'], 'http') !== 0) {
                    $p['image'] = 'http://localhost/SAE401/images/' . ltrim($p['image'], '/');
                }
            }
            header('Content-Type: application/json');
            echo json_encode($carrouselPartenaires);
            return null;
        }
        return $this->render('index', compact('carrousel'), $api);
    }

    /**
     * Crée un nouvel élément dans le carrousel
     * @return void
     */
    
    // POST /api/carrousel

    public function create($api = false): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            if (empty($data)) {
                $data = json_decode(file_get_contents('php://input'), true);
            }
            try {
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = 'images/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
                    $imagePath = $uploadDir . $imageName;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                        $data['image'] = $imagePath; // Stocke 'images/xxxx.jpg' en BDD
                    }
                }
                $success = $this->carrouselModel->create($data);
                $msg = $success ? "Élément ajouté au carrousel." : "Erreur lors de l'ajout.";
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

    /**
     * Met à jour un élément du carrousel
     * @param int $id
     * @return void
     */
    // PUT /api/carrousel/{id}

    public function update(int $id, $api = false): void {
        $data = $_POST;
        if (empty($data)) {
            $data = json_decode(file_get_contents('php://input'), true);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = 'images/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
                    $imagePath = $uploadDir . $imageName;
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                        $data['image'] = $imagePath; // Stocke 'images/xxxx.jpg' en BDD
                    }
                }
                $success = $this->carrouselModel->update($id, $data);
                $msg = $success ? "Élément du carrousel mis à jour." : "Erreur lors de la mise à jour.";
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
            $carrousel = $this->carrouselModel->getById($id);
            $this->render('update', compact('carrousel'));
        }
    }

    /**
     * Supprime un élément du carrousel
     * @param int $id
     * @return void
     */
    // DELETE /api/carrousel/{id}

    public function delete(int $id, $api = false): void {
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE' || $_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $success = $this->carrouselModel->delete($id);
                $msg = $success ? "Élément supprimé du carrousel." : "Erreur lors de la suppression.";
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
            $carrousel = $this->carrouselModel->getById($id);
            $this->render('delete', compact('carrousel'));
        }
    }
}