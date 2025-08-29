<?php
namespace controllers;
class Users extends \app\Controller {
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

    // POST /api/users/register
    public function Register(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->loadModel('Users');
            $userModel = $this->Users;
            $data = json_decode(file_get_contents('php://input'), true);
            $role = $data['role'] ?? '';
            // Vérification email déjà utilisé
            $email = $role === 'etudiant' ? ($data['email_etudiant'] ?? '') : ($data['email_particulier'] ?? '');
            if ($userModel->findByLogin($email)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Cet email est déjà utilisé.']);
                return;
            }
            $veutAdherent = ($role === 'etudiant' && !empty($data['adherent']));
            $userData = [
                'role' => $role,
                'password' => $data['password'] ?? '',
                'adherent' => 0,
            ];
            if ($role === 'etudiant') {
                $userData['email'] = $data['email_etudiant'] ?? '';
                $userData['numero_etudiant'] = $data['numero_etudiant'] ?? '';
                $userData['nom'] = $data['nom'] ?? '';
                $userData['prenom'] = $data['prenom'] ?? '';
            } else {
                $userData['email'] = $data['email_particulier'] ?? '';
                $userData['numero_etudiant'] = null;
                $userData['nom'] = $data['nom_particulier'] ?? '';
                $userData['prenom'] = $data['prenom_particulier'] ?? '';
            }
            if ($userModel->register($userData)) {
                $user = $userModel->findByLogin($userData['email']);
                if ($user) {
                    // Optionnel : auto-login, retour user
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true,
                        'user' => [
                            'id' => $user['id'],
                            'email' => $user['email'],
                            'prenom' => $user['prenom'],
                            'adherent' => $user['adherent'] ?? 0
                        ],
                        'message' => 'Inscription réussie.'
                    ]);
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Erreur lors de la connexion automatique.']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la création du compte.']);
            }
        } else {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Méthode non autorisée']);
        }
    }

    // GET /api/users/activate
    public function Activate(): void {
        header('Content-Type: application/json');
        echo json_encode(['message' => 'Merci, votre adresse mail est maintenant confirmée !']);
    }

    // POST /api/users/login
    public function Login(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->loadModel('Users');
            $userModel = $this->Users;
            $data = json_decode(file_get_contents('php://input'), true);
            $login = $data['login'] ?? '';
            $password = $data['password'] ?? '';
            if (empty($login) || empty($password)) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs.']);
                return;
            }
            $user = $userModel->findByLogin($login);
            if ($user && password_verify($password, $user['password'])) {
                $token = bin2hex(random_bytes(32));
                $userModel->updateToken($user['email'], $token);
                // Optionnel : durée d'expiration
                $expire = time() + 3600;
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'prenom' => $user['prenom'],
                    'email' => $user['email'],
                    'adherent' => $user['adherent'] ?? 0,
                    'token' => $token,
                    'token_expire' => $expire
                ];
                setcookie('token', $token, $expire);
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'user' => [
                        'id' => $user['id'],
                        'prenom' => $user['prenom'],
                        'email' => $user['email'],
                        'adherent' => $user['adherent'] ?? 0,
                        'token' => $token
                    ],
                    'message' => 'Connexion réussie.'
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => "Nom d'utilisateur, email ou mot de passe incorrect."]);
            }
        } else {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Méthode non autorisée']);
        }
    }

    public function logout() {
        setcookie('token', '', time() - 3600, '/');
        session_destroy();
        header('Location: /');
        exit;
    }

   // GET /api/users/edit
    public function Edit(): void {
        if (empty($_SESSION['user'])) {
            http_response_code(401);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Utilisateur non connecté']);
            return;
        }
        $user = $_SESSION['user'];
        header('Content-Type: application/json');
        echo json_encode(['user' => $user]);
    }

    // POST /api/users/update
    public function apiUpdate(): void {
    $this->requireUser();
        $this->loadModel('Users');
        $userModel = $this->Users;
        $userId = $_SESSION['user']['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $prenom = $data['prenom'] ?? $_SESSION['user']['prenom'];
            $email = $data['email'] ?? $_SESSION['user']['email'];
            $password = !empty($data['password']) ? $data['password'] : null;
            $success = $userModel->updateProfile($userId, $prenom, $email, $password);
            if ($success) {
                $_SESSION['user']['prenom'] = $prenom;
                $_SESSION['user']['email'] = $email;
                $msg = "Profil mis à jour avec succès.";
            } else {
                $msg = "Erreur lors de la mise à jour du profil.";
            }
            $user = $_SESSION['user'];
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $success,
                'user' => $user,
                'message' => $msg
            ]);
        } else {
            http_response_code(405);
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Méthode non autorisée']);
        }
    }

    // GET /api/users/pay
    public function apiPay(): void {
    $this->requireUser();
        // Exemple de structure à adapter selon le besoin réel
        $user = $_SESSION['user'];
        $data = [
            'user' => $user,
            'message' => 'Veuillez procéder au paiement pour devenir adhérent.'
        ];
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    // POST /api/users/pay
    public function apiPayProcess(): void {
    $this->requireUser();
        $this->loadModel('Users');
        $userId = $_SESSION['user']['id'];
        $this->Users->setAdherent($userId);
        $_SESSION['user']['adherent'] = 1;
        $msg = "Paiement réussi, vous êtes maintenant adhérent !";
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => $msg,
            'user' => $_SESSION['user']
        ]);
    }
    // GET /api/users/account
    public function apiAccount(): void {
    $this->requireUser();
        $this->loadModel('Reservations');
        $reservations = $this->Reservations->getByUser($_SESSION['user']['id']);
        $user = $_SESSION['user'];
        header('Content-Type: application/json');
        echo json_encode([
            'user' => $user,
            'reservations' => $reservations
        ]);
    }
    // Page de compte utilisateur (frontend)
    public function account(): void {
        $this->requireUser();
        $this->loadModel('Reservations');
        $reservations = $this->Reservations->getByUser($_SESSION['user']['id']);
        $user = $_SESSION['user'];
        $this->render('account', compact('user', 'reservations'));
    }

    public function deleteAccount(): void {
    $this->requireUser();
        $this->loadModel('Users');
        $userId = $_SESSION['user']['id'];
        $success = $this->Users->deleteAccount($userId);
        if ($success) {
            setcookie('user_token', '', time() - 3600, '/');
            session_destroy();
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Compte supprimé avec succès.']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression du compte.']);
        }
    }
}
?>