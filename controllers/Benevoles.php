<?php
namespace controllers;

class Benevoles extends \app\Controller {
    // GET /api/benevoles
    public function Index(): void {
        $this->loadModel('Benevoles');
        $data = [
            'benevoles_non_valides' => $this->Benevoles->getNonValides(),
            'benevoles_valides' => $this->Benevoles->getValides()
        ];
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    // PUT /api/benevoles/{id}/action
    public function UpdateBenevole($id): void {
        $this->loadModel('Benevoles');
        $data = json_decode(file_get_contents('php://input'), true);
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
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'message' => $msg,
            'benevoles_non_valides' => $this->Benevoles->getNonValides(),
            'benevoles_valides' => $this->Benevoles->getValides()
        ]);
    }

    // GET /api/benevoles/liste
    public function Liste(): void {
        $this->loadModel('Benevoles');
        $benevoles = $this->Benevoles->getAll();
        header('Content-Type: application/json');
        echo json_encode($benevoles);
    }

    // Affiche le formulaire d'inscription bénévole
    public function form_benevole() {
        $this->render('form_benevole');
    }

    // Ajoute un bénévole (depuis le formulaire public)
    // POST /api/benevoles
    public function Ajouter(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->loadModel('Benevoles');
            $data = json_decode(file_get_contents('php://input'), true);
            $success = $this->Benevoles->create($data);
            $msg = $success ? "Votre demande de bénévolat a bien été envoyée. Merci !" : "Erreur lors de l'envoi de la demande.";
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