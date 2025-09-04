<?php
namespace app;

class Database {
    private static ?Database $instance = null;
    private \mysqli $connexion;

    private function __construct() {
        $this->connexion = new \mysqli("localhost", "root", "", "sae401_epise");
        $this->connexion->set_charset("utf8");
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): \mysqli {
        return $this->connexion;
    }
}