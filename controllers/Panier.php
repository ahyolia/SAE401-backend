<?php
namespace controllers;

class Panier extends \app\Controller {
    public function index() {
        $this->render('index');
    }

    public function valider() {
        if (
            empty($_SESSION['user']) ||
            empty($_COOKIE['token']) ||
            $_SESSION['user']['token'] !== $_COOKIE['token'] ||
            $_SESSION['user']['token_expire'] < time()
        ) {
            echo json_encode([
                'success' => false,
                'message' => 'Votre session a expiré. Veuillez vous reconnecter pour commander.'
            ]);
            exit;
        }
        $this->loadModel('Users');
        $userId = $_SESSION['user']['id'];
        $user = $this->Users->findById($userId);

        if ($user['role'] !== 'etudiant') {
            echo json_encode(['success' => false, 'message' => 'Seuls les étudiants peuvent réserver un panier.']);
            exit;
        }

        if (!$this->Users->isAdherent($userId)) {
            echo json_encode(['success' => false, 'message' => 'Vous devez payer votre adhésion pour valider le panier.']);
            exit;
        }

        // Limite de 2 paniers/semaine
        $this->loadModel('Reservations');
        $nbPaniers = $this->Reservations->countThisWeek($userId);
        if ($nbPaniers >= 2) {
            echo json_encode(['success' => false, 'message' => 'Vous avez déjà validé 2 paniers cette semaine.']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $this->loadModel('Produits');
        foreach ($data as $item) {
            // Vérifie que la quantité demandée ne dépasse pas le stock disponible
            $produit = $this->Produits->getById($item['id']);
            if (!$produit || $produit['stock'] < $item['quantity']) {
                echo json_encode(['success' => false, 'message' => 'Stock insuffisant pour ' . htmlspecialchars($produit['name'] ?? 'ce produit') . '.']);
                exit;
            }
        }
        // Décrémente le stock après vérification
        foreach ($data as $item) {
            $this->Produits->decrementStock($item['id'], $item['quantity']);
        }
        // Calcule la quantité totale
        $quantiteTotale = 0;
        foreach ($data as $item) {
            $quantiteTotale += $item['quantity'];
        }

        $this->loadModel('Reservations');
        $userId = $_SESSION['user']['id'];
        $date = date('Y-m-d H:i:s');

        // 1. Insérer la réservation
        $reservationId = $this->Reservations->add($userId, $date);

        if (!$reservationId) {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la création de la réservation.']);
            exit;
        }

        // 2. Insérer chaque produit réservé
        foreach ($data as $item) {
            $this->Reservations->addProduit($reservationId, $item['id'], $item['quantity']);
        }

        // Vider le panier en session
        unset($_SESSION['panier']);

        // Réponse de succès
        echo json_encode(['success' => true, 'message' => 'Réservation enregistrée et panier vidé.']);
        exit;
    }
   

    public function stocks() {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->loadModel('Produits');
        $stocks = [];
        foreach ($data as $item) {
            $prod = $this->Produits->getById($item['id']);
            $stocks[$item['id']] = isset($prod['stock']) ? (int)$prod['stock'] : 99;
        }
        echo json_encode($stocks);
        exit;
    }
}
?>