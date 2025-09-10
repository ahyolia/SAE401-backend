<?php
namespace controllers;
use app\ModelFactory;

class Dons extends \app\Controller {
    // Mutualisation de la vérification du token utilisateur
    private function requireUser() {
        if (
            empty($_SESSION['user']) ||
            empty($_COOKIE['token']) ||
            $_SESSION['user']['token'] !== $_COOKIE['token'] ||
            $_SESSION['user']['token_expire'] < time()
        ) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Votre session a expiré. Veuillez vous reconnecter pour continuer.']);
            exit;
        }
    }

    // POST /api/dons

    public function ajouter($api = false): void {
        if (
            empty($_SESSION['user']) ||
            empty($_COOKIE['token']) ||
            $_SESSION['user']['token'] !== $_COOKIE['token'] ||
            $_SESSION['user']['token_expire'] < time()
        ) {
            if ($api) {
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Accès interdit, veuillez vous connecter.']);
                return;
            }
            $_SESSION['msg'] = "Vous devez être connecté pour faire un don.";
            header('Location: /users/login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->requireUser();
            $this->loadModel('Dons');
            $data = $_POST;
            if (empty($data)) {
                $data = json_decode(file_get_contents('php://input'), true);
            }

            // Gestion de l'upload d'image
            $imagePath = null;
            if (!empty($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'images/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $imageName = uniqid() . '_' . basename($_FILES['photo']['name']);
                $imagePath = $uploadDir . $imageName;
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $imagePath)) {
                    $data['image'] = $imagePath; // Stocke 'images/xxx.jpg' en BDD
                }
            }

            $don = [
                'user_id' => $_SESSION['user']['id'],
                'produit' => $data['produit'] ?? '',
                'quantite' => $data['quantite'] ?? 0,
                'categorie_id' => $data['categorie'] ?? null,
                'date_don' => date('Y-m-d H:i:s'),
                'image' => $data['image'] ?? null
            ];
            $success = $this->Dons->add($don);
            $msg = $success ? "Merci beaucoup pour votre don !" : "Erreur lors de l'enregistrement du don.";
            if ($api) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => $success,
                    'message' => $msg
                ]);
                return;
            }
            echo $msg;
        } else {
            $this->loadModel('Categories');
            $categories = $this->Categories->getAll();
            $this->render('ajouter', compact('categories'));
        }
    }
    
    public function listDons() {
        $this->loadModel('Dons');
        $dons = $this->Dons->getAll();
        foreach ($dons as &$don) {
            if (!empty($don['image']) && strpos($don['image'], 'http') !== 0) {
                $don['image'] = 'http://localhost/SAE401/images/' . ltrim($don['image'], '/');
            }
        }
        echo json_encode($dons);
    }
    
    public function index($api = false) {
        $this->loadModel('Dons');
        $dons = $this->Dons->getAll();
        // Ajoute le chemin complet pour les images
        foreach ($dons as &$don) {
            if (!empty($don['image']) && strpos($don['image'], 'http') !== 0) {
                $don['image'] = 'http://localhost/SAE401/images/' . ltrim($don['image'], '/');
            }
        }
        if ($api) {
            header('Content-Type: application/json');
            echo json_encode($dons);
            return null;
        }
        // Sinon, affiche la vue classique
        $this->render('dons', compact('dons'));
    }
}
?>
