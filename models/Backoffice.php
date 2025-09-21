<?php
<?php
namespace models;

class Backoffice extends \app\Model {
    public function __construct() {
        $this->table = "backoffice"; // ou le nom de la table si besoin
        parent::__construct();
    }
    // Ajoute ici les méthodes spécifiques si besoin
}