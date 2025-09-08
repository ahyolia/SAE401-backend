<?php
require_once 'app/ModelInterface.php';
require_once 'app/ModelFactory.php';
require_once 'app/Model.php'; 

$models = [
    'Produits',
    'Articles',
    'Categories',
    'Dons',
    'Benevoles',
    'Carrousel',
    'Reservations',
    'Users',
    'administrateur'
];

foreach ($models as $modelName) {
    $modelFile = "models/$modelName.php";
    if (!file_exists($modelFile)) {
        echo "Fichier $modelFile absent, test ignoré.\n";
        continue;
    }
    require_once $modelFile;
    try {
        $instance = \app\ModelFactory::create($modelName);
        $expectedClass = "\\models\\$modelName";
        echo ($instance instanceof $expectedClass) ? "Factory $modelName OK\n" : "Factory $modelName FAIL\n";
        // Test d'une méthode clé
        if (method_exists($instance, 'getAll')) {
            $all = $instance->getAll();
            echo is_array($all) ? "Appel $modelName::getAll() OK\n" : "Appel $modelName::getAll() FAIL\n";
        } elseif (method_exists($instance, 'getNonValides')) {
            $nv = $instance->getNonValides();
            echo is_array($nv) ? "Appel $modelName::getNonValides() OK\n" : "Appel $modelName::getNonValides() FAIL\n";
        }
    } catch (Exception $e) {
        echo "Factory $modelName Exception: " . $e->getMessage() . "\n";
    }
}
?>