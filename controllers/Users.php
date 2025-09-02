<?php
namespace controllers;
class Users extends \app\Controller {
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

    // POST /api/users/register

    public function register($api = false): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->loadModel('Users');
            $userModel = $this->Users;
            $data = $_POST;
            if (empty($data)) {
                $data = json_decode(file_get_contents('php://input'), true);
            }
            $role = $data['role'] ?? '';
            $email = $role === 'etudiant' ? ($data['email_etudiant'] ?? '') : ($data['email_particulier'] ?? '');
            if ($userModel->findByLogin($email)) {
                if ($api) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Cet email est déjà utilisé.']);
                    return;
                }
                $this->render('register', ['message' => 'Cet email est déjà utilisé.']);
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
                    if ($api) {
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
                        return;
                    }
                    $this->render('register', ['message' => 'Inscription réussie.']);
                } else {
                    if ($api) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => false, 'message' => 'Erreur lors de la connexion automatique.']);
                        return;
                    }
                    $this->render('register', ['message' => 'Erreur lors de la connexion automatique.']);
                }
            } else {
                if ($api) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Erreur lors de la création du compte.']);
                    return;
                }
                $this->render('register', ['message' => 'Erreur lors de la création du compte.']);
            }
        } else {
            if ($api) {
                http_response_code(405);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Méthode non autorisée']);
                return;
            }
            $this->render('register');
        }
    }

    // GET /api/users/activate

    public function activate($api = false): void {
        $msg = ['message' => 'Merci, votre adresse mail est maintenant confirmée !'];
        if ($api) {
            header('Content-Type: application/json');
            echo json_encode($msg);
            return;
        }
        $this->render('activate', $msg);
    }

    // POST /api/users/login

    public function login($api = false): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->loadModel('Users');
            $userModel = $this->Users;
            $data = $_POST;
            if (empty($data)) {
                $data = json_decode(file_get_contents('php://input'), true);
            }
            $login = $data['login'] ?? '';
            $password = $data['password'] ?? '';
            if (empty($login) || empty($password)) {
                if ($api) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs.']);
                    return;
                }
                $this->render('login', ['message' => 'Veuillez remplir tous les champs.']);
                return;
            }
            $user = $userModel->findByLogin($login);
            if ($user && password_verify($password, $user['password'])) {
                $token = bin2hex(random_bytes(32));
                $userModel->updateToken($user['email'], $token);
                $expire = time() + 3600;
                setcookie('token', $token, $expire, '/');
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'prenom' => $user['prenom'],
                    'email' => $user['email'],
                    'adherent' => $user['adherent'] ?? 0,
                    'token' => $token,
                    'token_expire' => $expire
                ];
                header('Location: /');
                exit;
            } else {
                if ($api) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => "Nom d'utilisateur, email ou mot de passe incorrect."]);
                    return;
                }
                $this->render('login', ['message' => "Nom d'utilisateur, email ou mot de passe incorrect."]);
            }
        } else {
            if ($api) {
                http_response_code(405);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Méthode non autorisée']);
                return;
            }
            // Affiche le formulaire de connexion en GET (hors API)
            $this->render('login');
        }
    }


    public function logout($api = false): void {
        setcookie('token', '', time() - 3600, '/');
        session_destroy();
        if ($api) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Déconnexion réussie.']);
            return;
        }
        header('Location: /');
        exit;
    }

   // GET /api/users/edit

    public function edit($api = false): void {
        if (empty($_SESSION['user'])) {
            if ($api) {
                http_response_code(401);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Utilisateur non connecté']);
                return;
            }
            $this->render('edit', ['message' => 'Utilisateur non connecté']);
            return;
        }
        $user = $_SESSION['user'];
        if ($api) {
            header('Content-Type: application/json');
            echo json_encode(['user' => $user]);
            return;
        }
        $this->render('edit', compact('user'));
    }

    // POST /api/users/update

    public function apiUpdate($api = false): void {
        $this->requireUser();
        $this->loadModel('Users');
        $userModel = $this->Users;
        $userId = $_SESSION['user']['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            if (empty($data)) {
                $data = json_decode(file_get_contents('php://input'), true);
            }
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
            if ($api) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => $success,
                    'user' => $user,
                    'message' => $msg
                ]);
                return;
            }
            echo $msg;
        } else {
            if ($api) {
                http_response_code(405);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Méthode non autorisée']);
                return;
            }
            echo 'Méthode non autorisée.';
        }
    }

    // GET /api/users/pay

    public function apiPay($api = false): void {
        $this->requireUser();
        $user = $_SESSION['user'];
        $data = [
            'user' => $user,
            'message' => 'Veuillez procéder au paiement pour devenir adhérent.'
        ];
        if ($api) {
            header('Content-Type: application/json');
            echo json_encode($data);
            return;
        }
        echo $data['message'];
    }

    // POST /api/users/pay

    public function apiPayProcess($api = false): void {
        $this->requireUser();
        $this->loadModel('Users');
        $userId = $_SESSION['user']['id'];
        $this->Users->setAdherent($userId);
        $_SESSION['user']['adherent'] = 1;
        $msg = "Paiement réussi, vous êtes maintenant adhérent !";
        if ($api) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => $msg,
                'user' => $_SESSION['user']
            ]);
            return;
        }
        echo $msg;
    }
    // GET /api/users/account

    public function apiAccount($api = false): void {
        $this->requireUser();
        $this->loadModel('Reservations');
        $reservations = $this->Reservations->getByUser($_SESSION['user']['id']);
        $user = $_SESSION['user'];
        $data = [
            'user' => $user,
            'reservations' => $reservations
        ];
        if ($api) {
            header('Content-Type: application/json');
            echo json_encode($data);
            return;
        }
        $this->render('account', $data);
    }
    // Page de compte utilisateur (frontend)

    public function account($api = false): void {
        $this->requireUser();
        $this->loadModel('Reservations');
        $this->loadModel('Dons');
        $user = $_SESSION['user'];
        $userId = $user['id'];
        $reservations = $this->Reservations->getByUserId($userId);
        $dons = $this->Dons->getByUserId($userId);
        $this->render('account', compact('user', 'reservations', 'dons'));
    }


    public function deleteAccount($api = false): void {
        $this->requireUser();
        $this->loadModel('Users');
        $userId = $_SESSION['user']['id'];
        $success = $this->Users->deleteAccount($userId);
        if ($success) {
            setcookie('token', '', time() - 3600, '/');
            session_destroy();
            if ($api) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Compte supprimé avec succès.']);
                return;
            }
            echo 'Compte supprimé avec succès.';
        } else {
            if ($api) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression du compte.']);
                return;
            }
            echo 'Erreur lors de la suppression du compte.';
        }
    }
}
?>