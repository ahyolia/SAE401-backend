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
            $don = [
                'user_id' => $_SESSION['user']['id'],
                'produit' => $data['produit'] ?? '',
                'quantite' => $data['quantite'] ?? 0,
                'categorie_id' => $data['categorie'] ?? null,
                'date_don' => date('Y-m-d H:i:s')
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
    
}
?>
