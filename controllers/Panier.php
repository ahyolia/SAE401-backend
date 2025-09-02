<?php
namespace controllers;

class Panier extends \app\Controller {

    public function index($api = false): mixed {
        if ($api && (
            empty($_SESSION['user']) ||
            empty($_COOKIE['token']) ||
            $_SESSION['user']['token'] !== $_COOKIE['token'] ||
            $_SESSION['user']['token_expire'] < time()
        )) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Accès interdit, veuillez vous connecter.']);
            return null;
        }
        $this->render('index');
        return null;
    }

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

        if (!$reservationId) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la création de la réservation.']);
            return;
        }

        foreach ($data as $item) {
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
}
?>