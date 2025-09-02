<?php
namespace controllers;

class Benevoles extends \app\Controller {

    // GET /api/benevoles
    public function index($api = false): mixed {
        $this->loadModel('Benevoles');
        $data = [
            'benevoles_non_valides' => $this->Benevoles->getNonValides(),
            'benevoles_valides' => $this->Benevoles->getValides()
        ];
        if ($api) {
            header('Content-Type: application/json');
            echo json_encode($data);
            return null;
        }
        return $this->render('index', $data, $api);
    }


    // PUT /api/benevoles/{id}/action
    public function updateBenevole($id, $api = false): void {
        $this->loadModel('Benevoles');
        $data = $_POST;
        if (empty($data)) {
            $data = json_decode(file_get_contents('php://input'), true);
        }
        $action = $data['action'] ?? '';
        $msg = '';
        $success = false;
        if ($action === 'valider') {
            $success = $this->Benevoles->valider($id);
            $msg = "Bénévole accepté et ajouté à la liste.";
        } elseif ($action === 'refuser' || $action === 'supprimer') {
            $success = $this->Benevoles->delete($id);
            $msg = ($action === 'refuser') ? "Bénévole refusé et supprimé." : "Bénévole validé supprimé.";
        } else {
            $msg = 'Action non reconnue.';
        }
        if ($api) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $success,
                'message' => $msg,
                'benevoles_non_valides' => $this->Benevoles->getNonValides(),
                'benevoles_valides' => $this->Benevoles->getValides()
            ]);
            return;
        }
        $data = [
            'msg' => $msg,
            'benevoles_non_valides' => $this->Benevoles->getNonValides(),
            'benevoles_valides' => $this->Benevoles->getValides()
        ];
        $this->render('updateBenevole', $data);
    }


    // GET /api/benevoles/liste
    public function liste($api = false): mixed {
        $this->loadModel('Benevoles');
        $benevoles = $this->Benevoles->getAll();
        if ($api) {
            header('Content-Type: application/json');
            echo json_encode($benevoles);
            return null;
        }
        return $this->render('liste', compact('benevoles'), $api);
    }


    // Affiche le formulaire d'inscription bénévole
    public function form_benevole() {
        $this->render('form_benevole');
    }


    // Ajoute un bénévole (depuis le formulaire public)
    // POST /api/benevoles
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
            $_SESSION['msg'] = "Vous devez être connecté pour devenir bénévole.";
            header('Location: /users/login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->loadModel('Benevoles');
            $data = $_POST;
            if (empty($data)) {
                $data = json_decode(file_get_contents('php://input'), true);
            }
            try {
                $success = $this->Benevoles->create($data);
                $msg = $success ? "Votre demande de bénévolat a bien été envoyée. Merci !" : "Erreur lors de l'envoi de la demande.";
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
            $this->render('ajouter');
        }
    }



}