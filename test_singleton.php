<?php
require_once 'app/Database.php';
require_once 'app/Model.php';
require_once 'models/Categories.php';
require_once 'models/Articles.php';
require_once 'models/Produits.php';

use app\Database;
use models\Categories;
use models\Articles;
use models\Produits;

// Test Singleton sur Database
$db1 = Database::getInstance();
$db2 = Database::getInstance();
echo ($db1 === $db2) ? "Singleton Database OK\n" : "Singleton Database FAIL\n";

// Test unicité de la connexion dans les modèles
$cat = new Categories();
$art = new Articles();
$prod = new Produits();

$connCat = $cat->getConnection();
$connArt = $art->getConnection();
$connProd = $prod->getConnection();

if ($connCat === $connArt && $connArt === $connProd) {
    echo "Toutes les connexions modèles sont identiques (Singleton OK)\n";
} else {
    echo "Les connexions modèles sont différentes (Singleton FAIL)\n";
}

// Test requête simple via un modèle
$result = $cat->getConnection()->query("SELECT 1");
echo ($result ? "Requête test OK\n" : "Requête test FAIL\n");
