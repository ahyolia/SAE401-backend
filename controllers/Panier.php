<?php
namespace controllers;

use app\ModelFactory;

class Panier extends \app\Controller {

    public function index($api = false): mixed {
        // Affichage du panier : public
        if ($api) {
            $this->render('index');
            return null;
        }
        $this->render('index');
        return null;
    }

    // Pour valider le panier (réservation), garde la protection :
    public function valider($api = false): void {
        if ($api && (
            empty($_SESSION['user']) ||
            empty($_COOKIE['token']) ||
            $_SESSION['user']['token'] !== $_COOKIE['token'] ||
            $_SESSION['user']['token_expire'] < time()
        )) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Accès interdit, veuillez vous connecter.']);
            return;
        }
        if (
            empty($_SESSION['user']) ||
            empty($_COOKIE['token']) ||
            $_SESSION['user']['token'] !== $_COOKIE['token'] ||
            $_SESSION['user']['token_expire'] < time()
        ) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Votre session a expiré. Veuillez vous reconnecter pour commander.'
            ]);
            return;
        }
        $this->loadModel('Users');
        $userId = $_SESSION['user']['id'];
        $user = $this->Users->findById($userId);

        if ($user['role'] !== 'etudiant') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Seuls les étudiants peuvent réserver un panier.']);
            return;
        }

        if (!$this->Users->isAdherent($userId)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Vous devez payer votre adhésion pour valider le panier.']);
            return;
        }

        $this->loadModel('Reservations');
        $nbPaniers = $this->Reservations->countThisWeek($userId);
        if ($nbPaniers >= 2) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Vous avez déjà validé 2 paniers cette semaine.']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $this->loadModel('Produits');
        foreach ($data as $item) {
            $produit = $this->Produits->getById($item['id']);
            if (!$produit || $produit['stock'] < $item['quantity']) {
                if ($api) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Stock insuffisant pour ' . htmlspecialchars($produit['name'] ?? 'ce produit') . '.']);
                    return;
                }
                echo 'Stock insuffisant pour ' . htmlspecialchars($produit['name'] ?? 'ce produit') . '.';
                return;
            }
        }
        foreach ($data as $item) {
            $this->Produits->decrementStock($item['id'], $item['quantity']);
        }
        $quantiteTotale = 0;
        foreach ($data as $item) {
            $quantiteTotale += $item['quantity'];
        }

        $this->loadModel('Reservations');
        $userId = $_SESSION['user']['id'];
        $date = date('Y-m-d H:i:s');

        // Si tout est OK, on crée la réservation
        $reservationId = $this->Reservations->add($userId, $date);
        foreach ($data as $item) {
            error_log("Ajout produit à la réservation: res=$reservationId, prod={$item['id']}, qty={$item['quantity']}");
            $this->Reservations->addProduit($reservationId, $item['id'], $item['quantity']);
        }

        unset($_SESSION['panier']);

        // Réponse JSON pour le JS
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Réservation enregistrée et panier vidé.']);
    }
   


    public function stocks($api = false): void {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->loadModel('Produits');
        $stocks = [];
        foreach ($data as $item) {
            $prod = $this->Produits->getById($item['id']);
            $stocks[$item['id']] = isset($prod['stock']) ? (int)$prod['stock'] : 99;
        }
        header('Content-Type: application/json');
        echo json_encode($stocks);
    }

    // GET /api/panier
    public function apiGet($api = false): void {
        $this->requireUser();
        $this->loadModel('Panier');
        $userId = $_SESSION['user']['id'];
        $panier = $this->Panier->getByUser($userId);
        error_log('API GET panier: user_id=' . $userId . ' panier=' . print_r($panier, true));
        header('Content-Type: application/json');
        echo json_encode(['panier' => $panier]);
    }

    // POST /api/panier
    public function apiPost($api = false): void {
        $this->requireUser();
        $this->loadModel('Panier');
        $userId = $_SESSION['user']['id'];
        $data = json_decode(file_get_contents('php://input'), true);
        $success = $this->Panier->save($userId, $data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    // PUT /api/panier
    public function apiPut($api = false): void {
        $this->requireUser();
        $this->loadModel('Panier');
        $userId = $_SESSION['user']['id'];
        $data = json_decode(file_get_contents('php://input'), true);
        $success = $this->Panier->update($userId, $data);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    // DELETE /api/panier
    public function apiDelete($api = false): void {
        $this->requireUser();
        $this->loadModel('Panier');
        $userId = $_SESSION['user']['id'];
        $success = $this->Panier->delete($userId);
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
    }

    public function requireUser() {
        if (
            empty($_SESSION['user']) ||
            empty($_SESSION['user']['token']) ||
            empty($_SESSION['user']['token_expire']) ||
            $_SESSION['user']['token_expire'] < time() ||
            empty($_COOKIE['token']) ||
            $_SESSION['user']['token'] !== $_COOKIE['token']
        ) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Votre session a expirée. Veuillez vous reconnecter.']);
            exit;
        }
    }

    public function getByUser($userId) {
        $sql = "SELECT produits FROM panier WHERE user_id = ?";
        $stmt = $this->getConnection()->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        error_log('Lecture panier BDD: ' . print_r($row, true));
        return $row ? json_decode($row['produits'], true) : [];
    }
}
?>