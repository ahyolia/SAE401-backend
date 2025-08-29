<?php
session_start();

define('ROOT', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));


// Inclusion des classes de base nécessaires aux modèles et aux contrôleurs
require_once(ROOT.'app/Model.php');
require_once(ROOT.'app/Controller.php');
require_once(ROOT.'app/Debug.php');
// à commenter pour désactiver le mode debug
\app\Debug::$actif = true;

if (
    strpos($_SERVER['REQUEST_URI'], '/backoffice') === 0 &&
    !isset($_SESSION['connecte']) &&
    strpos($_SERVER['REQUEST_URI'], '/backoffice/connexion') !== 0
) {
    header('Location: /backoffice/connexion');
    exit;
}

// On sépare les paramètres et on les met dans le tableau $params
$params = explode('/', $_GET['p']);

// Si au moins 1 paramètre existe
if($params[0] != ""){
    if (strpos($params[0], 'api') === 0) {
        $controller = "\\controllers\\" . ucfirst($params[0]);
        require_once(ROOT . 'controllers/Api.php');
        $c = new $controller();
        // Appelle la méthode index du contrôleur Api avec tous les paramètres
        $c->index(...array_slice($params, 1));
        exit;
    }

    // On sauvegarde le 1er paramètre dans $controller en mettant sa 1ère lettre en majuscule
    $controller = "\\controllers\\".ucfirst($params[0]);

    // On sauvegarde le 2ème paramètre dans $action si il existe, sinon index
    $action = isset($params[1]) ? $params[1] : 'index';
    
    if(file_exists(ROOT.str_replace('\\', DIRECTORY_SEPARATOR, $controller).'.php')) {
        // On appelle le contrôleur
        require_once(ROOT.str_replace('\\', DIRECTORY_SEPARATOR, $controller).'.php');
    
        // On instancie le contrôleur
        $controller = new $controller();

        if(method_exists($controller, $action)){
            // On supprime les 2 premiers paramètres
            unset($params[0]);
            unset($params[1]);

            // On appelle la méthode $action du contrôleur $controller
            call_user_func_array([$controller,$action], $params);      

        } else {
            // On envoie le code réponse 404
            http_response_code(404);
            echo "La page recherchée n'existe pas";
        }
    } else {
        // On envoie le code réponse 404
        http_response_code(404);
        echo "La page recherchée n'existe pas";
    }
} else {
    // Ici aucun paramètre n'est défini
    // On appelle le contrôleur par défaut
    require_once(ROOT.'controllers/Main.php');

    // On instancie le contrôleur
    $controller = new \controllers\Main();

    // On appelle la méthode index
    $controller->index();
}
?>
