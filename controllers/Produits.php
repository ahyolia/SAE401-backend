<?php
namespace controllers;

use app\ModelFactory;

class Produits extends \app\Controller {

    protected $produitsModel;

    public function __construct() {
        $this->produitsModel = ModelFactory::create('Produits');
    }

    public function getAll() {
        return $this->produitsModel->getAll();
    }

    public function getById($id) {
        return $this->produitsModel->getById($id);
    }

    public function create($data) {
        return $this->produitsModel->create($data);
    }

    public function update($id, $data) {
        return $this->produitsModel->update($id, $data);
    }

    public function delete($id) {
        return $this->produitsModel->delete($id);
    }
}