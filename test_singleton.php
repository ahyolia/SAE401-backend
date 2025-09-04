<?php
require_once 'app/Database.php';

use app\Database;

// Test : on récupère deux fois l’instance
$db1 = Database::getInstance();
$db2 = Database::getInstance();

if ($db1 === $db2) {
    echo "Test OK : Singleton fonctionne, une seule instance.\n";
} else {
    echo "Test FAIL : Singleton ne fonctionne pas.\n";
}

// Test : accès à la connexion MySQL
$conn = $db1->getConnection();
if ($conn instanceof mysqli) {
    echo "Connexion MySQL OK\n";
    // Test requête simple
    $result = $conn->query("SELECT 1");
    if ($result) {
        echo "Requête test OK\n";
    } else {
        echo "Requête test FAIL\n";
    }
} else {
    echo "Connexion MySQL FAIL\n";
}