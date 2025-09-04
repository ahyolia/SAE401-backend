<?php
namespace app;

class Database {
    private static ?Database $instance = null;
    static private \mysqli $_connexion;

    // Le constructeur est privé pour empêcher l'instanciation directe
    private function __construct() {
        self::$_connexion = new \mysqli("localhost", "root", "", "sae401_epise");
        self::$_connexion->set_charset("utf8");
    }

    // Méthode statique pour obtenir l'instance unique
    public static function getInstance(): Database {
        if (self::$instance === null) {
            // Si l'instance n'a pas encore été crée, on la crée
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Méthode centralisée pour exécuter une requête SQL
    public function query(string $sql) {
        return self::$_connexion->query($sql);
    }

    // Accès direct à la connexion si besoin
    public static function getConnection(): \mysqli {
        if (!isset(self::$_connexion)) {
            try {
                self::$_connexion = new \mysqli("localhost", "root", "", "sae401_epise");
                self::$_connexion->set_charset("utf8");
            } catch (\Exception $e) {
                die("Erreur de connexion MySQL : " . $e->getMessage());
            }
        }
        return self::$_connexion;
    }
}