<?php
namespace controllers;

class Dons extends \app\Controller {
    // Mutualisation de la vérification du token utilisateur
    private function requireUser() {
        if (
            empty($_SESSION['user']) ||
            empty($_COOKIE['user_token']) ||
            $_SESSION['user']['token'] !== $_COOKIE['user_token'] ||
            $_SESSION['user']['token_expire'] < time()
        ) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Votre session a expiré. Veuillez vous reconnecter pour continuer.']);
            exit;
        }
    }

    // POST /api/dons
    public function Ajouter(): void {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->requireUser();
            $this->loadModel('Dons');
            $data = json_decode(file_get_contents('php://input'), true);
            $don = [
                'user_id' => $_SESSION['user']['id'],
                'produit' => $data['produit'] ?? '',
                'quantite' => $data['quantite'] ?? 0,
                'categorie_id' => $data['categorie'] ?? null,
                'date_don' => date('Y-m-d H:i:s')
            ];
            $success = $this->Dons->add($don);
            $msg = $success ? "Merci beaucoup pour votre don !" : "Erreur lors de l'enregistrement du don.";
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
?>
