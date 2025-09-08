<?php
namespace controllers;

require_once __DIR__ . '/../app/ModelFactory.php';
use app\ModelFactory;


class Catalogue extends \app\Controller {
    protected $catalogueModel;

    public function __construct() {
        //$this->catalogueModel = ModelFactory::create('Catalogue');
    }

    // GET /api/catalogue

    public function index($api = false): mixed {
        $this->loadModel('Produits');
        $this->loadModel('Categories');
        $produits = $this->Produits->getAll();
        $categories = $this->Categories->getAll();
        $data = [
            'produits' => $produits,
            'categories' => $categories,
            'activeCategory' => 'all'
        ];
        if ($api) {
            return json_encode($data);
        }
        return $this->render('index', $data, $api);
    }

    // GET /api/catalogue/categories/{id}

    public function categories($id, $api = false): mixed {
        $this->loadModel('Produits');
        $this->loadModel('Categories');
        $produits = $this->Produits->getByCategory($id);
        $categories = $this->Categories->getAll();
        $data = [
            'produits' => $produits,
            'categories' => $categories,
            'activeCategory' => $id
        ];
        if ($api) {
            header('Content-Type: application/json');
            echo json_encode($data);
            return null;
        }
        return $this->render('categories', $data, $api);
    }
    
}
?>