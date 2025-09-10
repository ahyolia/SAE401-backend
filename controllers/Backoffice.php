<?php

namespace controllers; 
use app\ModelFactory;

class Backoffice extends \app\Controller {  
    protected $backofficeModel;
    public function __construct() {
        $this->backofficeModel = ModelFactory::create('Backoffice');
    }

    private function requireAdmin() {
        if (!isset($_SESSION['connecte'])) {
            header('Location: /backoffice/connexion');
            exit;
        }
    }
    /**
    * Cette méthode appelle la vue adéquate en fonction de l'état de connexion de l'utilisateur
    * @return void
    */
    public function index(): void {
        // Vérifie si l'utilisateur est connecté
        if(isset($_SESSION['connecte'])){
            // Déconnexion
            if(isset($_POST['deco'])) {
                unset($_SESSION['connecte']);
                $_SESSION['msg'] = "Déconnexion réussie !";
                header('Location: /backoffice');
                exit;
            } else {
                // Changement de modèle
                if(isset($_POST['choisir'])) {
                    $_SESSION['modele'] = $_POST['modele'];
                }
                if(isset($_POST['changer'])) {
                    unset($_SESSION['modele']);
                }
                // Si un modèle est sélectionné
                if(isset($_SESSION['modele'])) {
                    $modele = $_SESSION['modele'];
                    $this->loadModel("$modele");
                    $bo = [];
                    if ($modele === 'Articles') {
                        $bo['articles'] = $this->Articles->getAll();
                        $this->loadModel('Categories');
                        $bo['categories'] = $this->Categories->getAll();
                    } elseif ($modele === 'Carrousel') {
                        $bo['carrousel'] = $this->Carrousel->getAll();
                    } elseif ($modele === 'Categories') {
                        $bo['categories'] = $this->Categories->getAll();
                    } elseif ($modele === 'Produits') {
                        $bo['produits'] = $this->Produits->getAll();
                        $this->loadModel('Categories');
                        $bo['categories'] = $this->Categories->getAll();
                    } elseif ($modele === 'Dons') {
                        $this->loadModel('Dons');
                        $bo['dons'] = $this->Dons->getNonValides();
                        $this->loadModel('Categories');
                        $bo['categories'] = $this->Categories->getAll();
                    } elseif ($modele === 'Benevoles') {
                        $this->loadModel('Benevoles');
                        $bo['benevoles'] = $this->Benevoles->getNonValides();
                        $bo['benevoles_valides'] = $this->Benevoles->getValides();
                    } elseif ($modele === 'Reservations') {
                        $this->loadModel('Reservations');
                        // Récupère les réservations en attente
                        $bo['reservations'] = $this->Reservations->getEnAttente();
                        // Récupère les réservations validées
                        $bo['reservations_valides'] = $this->Reservations->getValidees();
                    };
                    $bo['msg'] = "";
                    $this->render($modele, compact('bo'));
                } else {
                    $this->render('Articles');
                }
                
            }
        } else {
            // Non connecté
            $bo = array();
            $render = "connexion";
            // Affiche le message flash de déconnexion s'il existe
            if(isset($_SESSION['msg'])) {
                $bo['msg'] = $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            if(isset($_POST['valide'])) {
                if(isset($_POST['log']) && isset($_POST['pass'])){
                    $log = $_POST['log'];
                    $pass = $_POST['pass'];
                    $this->loadModel('administrateur');
                    if($this->administrateur->connexion($log, $pass)) {
                        $_SESSION['connecte'] = $log;
                        $_SESSION['modele'] = 'Articles';
                        header('Location: /backoffice');
                        exit;
                    } else {
                        $bo['msg'] = "Erreur de connexion !";
                    }
                } else {
                    $bo['msg'] = "Problème de formulaire";
                }
            }
            $this->render($render, compact('bo'));
        }
    }

    /**
    * Crée un nouvel élément dans le modèle sélectionné
    * @return void
    */
    public function create(): void {
        $this->requireAdmin();
        if (isset($_SESSION['modele'])) {
            $modele = $_SESSION['modele'];
            $this->loadModel($modele);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Gestion image pour Produits/Articles/Carrousel si besoin
                $data = $_POST;
                if (($modele === 'Produits' || $modele === 'Articles' || $modele === 'Carrousel') && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = 'images/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    $imagePath = $uploadDir . basename($_FILES['image']['name']);
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                        // $imagePath = 'images/monimage.jpg'
                        // Enregistre $imagePath dans la BDD
                        $data['image'] = $imagePath;
                    }
                }
                if ($modele === 'Produits') {
                    $name = $_POST['name'] ?? '';
                    $description = $_POST['description'] ?? '';
                    $stock = $_POST['stock'] ?? '';
                    $category_id = $_POST['category_id'] ?? '';
                    $image = null;
                    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = 'images/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }
                        $imagePath = $uploadDir . basename($_FILES['image']['name']);
                        if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                            $image = $imagePath;
                        }
                    }
                    if ($image !== null) {
                        $msg = $this->$modele->create($name, $description, $stock, $category_id, $image);
                    } else {
                        $msg = $this->$modele->create($name, $description, $stock, $category_id);
                    }
                    } else {
                        $msg = $this->$modele->create($data);
                    }
                // Rechargez les données
                if ($modele === 'Articles') {
                    $bo['articles'] = $this->Articles->getAll();
                    $this->loadModel('Categories');
                    $bo['categories'] = $this->Categories->getAll();
                } elseif ($modele === 'Carrousel') {
                    $bo['carrousel'] = $this->Carrousel->getAll();
                } elseif ($modele === 'Categories') {
                    $bo['categories'] = $this->Categories->getAll();
                } elseif ($modele === 'Produits') {
                    $bo['produits'] = $this->Produits->getAll();
                    $this->loadModel('Categories');
                    $bo['categories'] = $this->Categories->getAll();
                }
                $bo['msg'] = $msg;
                $this->render($modele, compact('bo'));
            } else {
                $bo = [];
                if ($modele === 'Articles' || $modele === 'Produits') {
                    $this->loadModel('Categories');
                    $bo['categories'] = $this->Categories->getAll();
                }
                $this->render('create', compact('bo'));
            }
        }
    }

    /**
    * Met à jour un élément en fonction de son ID
    * @param int $id
    * @return void
    */
    public function update(int $id): void {
        $this->requireAdmin();
        if(isset($_SESSION['modele'])) {
            $modele = $_SESSION['modele'];
            $this->loadModel($modele);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Si on veut supprimer
                if (isset($_POST['delete'])) {
                    $msg = $this->$modele->delete($id);
                } 
                // Sinon on modifie
                elseif (isset($_POST['update'])) {
                    if ($modele === 'Categories') {
                        $data['titre'] = $_POST['titre'] ?? '';
                        $msg = $this->$modele->update($id, $data);
                    } elseif ($modele === 'Produits') {
                        $name = $_POST['name'] ?? '';
                        $description = $_POST['description'] ?? '';
                        $stock = $_POST['stock'] ?? '';
                        $category_id = $_POST['category_id'] ?? '';
                        $image = null;
                        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                            $uploadDir = 'images/';
                            if (!is_dir($uploadDir)) {
                                mkdir($uploadDir, 0777, true);
                            }
                            $imagePath = $uploadDir . basename($_FILES['image']['name']);
                            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                                $image = $imagePath;
                            }
                        }
                        // On adapte l'appel selon la signature de Produits::update
                        if ($image !== null) {
                            $msg = $this->$modele->update($id, $name, $description, $stock, $category_id, $image);
                        } else {
                            $msg = $this->$modele->update($id, $name, $description, $stock, $category_id);
                        }
                    } elseif ($modele === 'Articles') {
                        // On passe toutes les données du formulaire à la méthode update du modèle Articles
                        $data = [
                            'titre' => $_POST['titre'] ?? '',
                            'contenu' => $_POST['contenu'] ?? '',
                            'slug' => $_POST['slug'] ?? '',
                            'article_categorie' => $_POST['article_categorie'] ?? ''
                        ];
                        $msg = $this->$modele->update($id, $data);
                    } else {
                        $data = [];
                        foreach ($_POST as $key => $value) {
                            $data[$key] = $value;
                        }
                        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                            $uploadDir = 'images/';
                            if (!is_dir($uploadDir)) {
                                mkdir($uploadDir, 0777, true);
                            }
                            $imagePath = $uploadDir . basename($_FILES['image']['name']);
                            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                                $data['image'] = $imagePath;
                            }
                        }
                        $msg = $this->$modele->update($id, $data);
                    }
                } else {
                    $msg = "Aucune action détectée.";
                }
                // Rechargez les données spécifiques au modèle
                if ($modele === 'Articles') {
                    $bo['articles'] = $this->Articles->getAll();
                    $this->loadModel('Categories');
                    $bo['categories'] = $this->Categories->getAll();
                } elseif ($modele === 'Carrousel') {
                    $bo['carrousel'] = $this->Carrousel->getAll();
                } elseif ($modele === 'Categories') {
                    $bo['categories'] = $this->Categories->getAll();
                } elseif ($modele === 'Produits') {
                    $bo['produits'] = $this->Produits->getAll();
                    $this->loadModel('Categories');
                    $bo['categories'] = $this->Categories->getAll();
                } elseif ($modele === 'Reservations') {
                    $this->loadModel('Reservations');
                    // Récupère les réservations en attente
                    $bo['reservations'] = $this->Reservations->getEnAttente();
                    // Récupère les réservations validées
                    $bo['reservations_valides'] = $this->Reservations->getValidees();
                }
                $bo['msg'] = $msg;
                $this->render("$modele", compact('bo'));
            } else {
                // Chargez les données de l'élément à modifier
                $item = $this->$modele->getById($id);
                $bo = ['item' => $item];
                if ($modele === 'Articles' || $modele === 'Produits') {
                    $this->loadModel('Categories');
                    $bo['categories'] = $this->Categories->getAll();
                }
                $this->render('update', compact('bo'));
            }
        } else {
            die("Aucun modèle sélectionné.");
        }
    }

    /**
    * Supprime un élément en fonction de son ID
    * @param int $id
    * @return void
    */
    public function delete(int $id): void {
        $this->requireAdmin();
        if (isset($_SESSION['modele'])) {
            $modele = $_SESSION['modele'];
            $this->loadModel($modele);
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $msg = $this->$modele->delete($id);
                // Rechargez les données
                if ($modele === 'Articles') {
                    $bo['articles'] = $this->Articles->getAll();
                    $this->loadModel('Categories');
                    $bo['categories'] = $this->Categories->getAll();
                } elseif ($modele === 'Carrousel') {
                    $bo['carrousel'] = $this->Carrousel->getAll();
                } elseif ($modele === 'Categories') {
                    $bo['categories'] = $this->Categories->getAll();
                } elseif ($modele === 'Produits') {
                    $bo['produits'] = $this->Produits->getAll();
                    $this->loadModel('Categories');
                    $bo['categories'] = $this->Categories->getAll();
                } elseif ($modele === 'Reservations') {
                    $this->loadModel('Reservations');
                    // Récupère les réservations en attente
                    $bo['reservations'] = $this->Reservations->getEnAttente();
                    // Récupère les réservations validées
                    $bo['reservations_valides'] = $this->Reservations->getValidees();
                }
                $bo['msg'] = $msg;
                $this->render($modele, compact('bo'));
            } else {
                $item = $this->$modele->getById($id);
                $bo = ['item' => $item];
                $this->render('delete', compact('bo'));
            }
        }
    }

    /**
    * Valide ou refuse un don, met à jour/crée le produit selon le don
    * @param int $id
    * @return void
    */
    public function updateDon($id): void {
        $this->loadModel('Dons');
        $this->loadModel('Produits');
        $this->loadModel('Categories');
        $don = $this->Dons->getById($id);

        if ($_POST['action'] === 'valider') {
            // Cherche le produit par nom
            $produit = $this->Produits->getByName($don['produit']);
            $quantite = isset($_POST['quantite']) ? intval($_POST['quantite']) : intval($don['quantite']);
            if ($produit) {
                // Met à jour le stock
                $newStock = $produit['stock'] + $quantite;
                $this->Produits->update($produit['id'], $produit['name'], $produit['description'], $newStock, $produit['category_id'], $produit['image']);
            } else {
                // Crée un nouveau produit
                $this->Produits->create($don['produit'], '', $quantite, $don['categorie_id']);
            }
            // Marque le don comme validé
            $this->Dons->valider($id);
            $msg = "Don validé et stock mis à jour.";
        } elseif ($_POST['action'] === 'refuser') {
            // Supprime le don
            $this->Dons->delete($id);
            $msg = "Don refusé et supprimé.";
        }
        // Recharge la liste des dons et des catégories pour la vue
        $bo['dons'] = $this->Dons->getNonValides();
        $bo['categories'] = $this->Categories->getAll();
        $bo['msg'] = $msg;
        $this->render('Dons', compact('bo'));
    }

    public function logout(): void {
        unset($_SESSION['connecte']);
        $_SESSION['msg'] = "Vous avez été déconnecté.";
        header('Location: /backoffice/connexion');
        exit;
    }

    public function updateBenevole($id): void {
        $this->loadModel('Benevoles');
        $benevole = $this->Benevoles->getById($id);

        if ($_POST['action'] === 'valider') {
            $this->Benevoles->valider($id);
            $msg = "Bénévole accepté et ajouté à la liste.";
        } elseif ($_POST['action'] === 'refuser') {
            $this->Benevoles->delete($id);
            $msg = "Bénévole refusé et supprimé.";
        }
        $bo['benevoles'] = $this->Benevoles->getNonValides();
        $bo['msg'] = $msg;
        $this->render('Benevoles', compact('bo'));
    }

    public function validerReservation() {
        if (isset($_POST['id'])) {
            $this->loadModel('Reservations');
            $this->Reservations->valider($_POST['id']);
        }
        header('Location: /backoffice?modele=Reservations');
        exit;
    }

    public function connexion(): void {
        $bo = [];
        $render = "connexion";
        if(isset($_SESSION['msg'])) {
            $bo['msg'] = $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        if(isset($_POST['valide'])) {
            if(isset($_POST['log']) && isset($_POST['pass'])){
                $log = $_POST['log'];
                $pass = $_POST['pass'];
                $this->loadModel('administrateur');
                if($this->administrateur->connexion($log, $pass)) {
                    $_SESSION['connecte'] = $log;
                    $_SESSION['modele'] = 'Articles';
                    header('Location: /backoffice');
                    exit;
                } else {
                    $bo['msg'] = "Erreur de connexion !";
                }
            } else {
                $bo['msg'] = "Problème de formulaire";
            }
        }
        $this->render($render, compact('bo'));
    }
}