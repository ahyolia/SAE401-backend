<?php
namespace controllers;

use app\models\Articles;
use app\models\Carrousel;
use app\models\Produits;
use app\models\Categories;
use app\models\Benevoles;
use app\models\Reservations;
use app\models\Dons;
use app\models\Users;
use app\models\Panier;

//FAUT RETOURNER LE LAST ID POUR CHAQUE INSERTIONS EN BDD (N°ID + Message de succès ou echec)

class Api extends \app\Controller{

    private function callControllerAction($controller, &$params, $defaultAction = 'index', $extraParam = null) {
        $action = $defaultAction;
        unset($params[0]);
        if($extraParam !== null) $params[] = $extraParam;
        if(method_exists($controller, $action)){
            $json = call_user_func_array([$controller, $action], $params);
            header('Content-Type: application/json');
            echo $json;
        } else {
            http_response_code(404);
            header('Content-Type: application/json');
            echo json_encode(['message' => 'Action non trouvée']);
        }
    }

    public function index(...$params) : string {
        // Protection API : accès uniquement si connecté
        // Sauf pour catalogue et articles
        $publicRoutes = ['catalogue', 'articles', 'carrousel', 'users', 'users/forgot', 'users/reset', 'panier'];
        if (
            !in_array($params[0] ?? '', $publicRoutes) &&
            (
                empty($_SESSION['user']) ||
                empty($_SESSION['user']['token']) ||
                empty($_SESSION['user']['token_expire']) ||
                $_SESSION['user']['token_expire'] < time() ||
                empty($_COOKIE['token']) ||
                $_SESSION['user']['token'] !== $_COOKIE['token']
            )
        ) {
            http_response_code(401);
            header('Content-Type: application/json');
            return json_encode(['error' => 'Accès API interdit : veuillez vous connecter.']);
        }
        if (!isset($params[0]) || empty($params[0])) {
            // Retourne la liste des routes disponibles
            header('Content-Type: application/json');
            return json_encode([
                "routes" => [
                    "/api/articles",
                    "/api/categories",
                    "/api/produits",
                    "/api/carrousel",
                    "/api/benevoles",
                    "/api/dons",
                    "/api/panier",
                    "/api/users"
                ]
            ]);
        }
        //    var_dump($params);
        if(isset($params[0])) {
            switch($_SERVER['REQUEST_METHOD']){
                case 'GET':
                    switch ($params[0]) {
                        case 'catalogue':
                            case 'articles':
                            case 'categories':
                            case 'benevoles':
                            case 'carrousel':
                            case 'dons':
                            case 'produits':
                            case 'users':
                            $controller = "\\controllers\\".ucfirst($params[0]);
                            require_once(ROOT.str_replace('\\', DIRECTORY_SEPARATOR, $controller).'.php');
                            $controller = new $controller();
                            if (isset($params[1]) && $params[1] === 'edit') {
                                $controller->edit(true);
                            } elseif (isset($params[1]) && $params[1] === 'account') {
                                $controller->account(true);
                            } else {
                                $this->callControllerAction($controller, $params, 'index', true);
                            }
                            break;
                            case 'panier':
                                require_once(ROOT.'controllers/Panier.php');
                                $controller = new \controllers\Panier();
                                $controller->apiGet(true);
                                break;
                            default:
                            http_response_code(405);
                            echo json_encode(['message' => 'Méthode non autorisée']);
                        break;
                    }
                break;
                case 'POST':
                    switch ($params[0]) {
                        case 'articles':
                        case 'categories':
                        case 'benevoles':
                        case 'carrousel':
                        case 'dons':
                        case 'produits':
                        case 'main':
                        case 'catalogue':
                        case 'users':
                            $controller = "\\controllers\\".ucfirst($params[0]);
                            require_once(ROOT.str_replace('\\', DIRECTORY_SEPARATOR, $controller).'.php');
                            $controller = new $controller();
                            if (isset($params[1]) && $params[1] === 'login') {
                                $controller->login(true);
                            } elseif (isset($params[1]) && $params[1] === 'forgot') {
                                $controller->forgot(true);
                            } elseif (isset($params[1]) && $params[1] === 'reset') {
                                $controller->reset(true);
                            } elseif (isset($params[1]) && $params[1] === 'payProcess') {
                                $controller->apiPayProcess(true);
                            } elseif (isset($params[1]) && $params[1] === 'register') {
                                $controller->register(true);
                            } elseif (isset($params[1]) && $params[1] === 'update') {
                                $controller->apiUpdate(true);
                            }
                            else {
                                $input = json_decode(file_get_contents('php://input'), true);
                                $this->callControllerAction($controller, $params, 'create', $input);
                            }
                            break;
                        case 'panier':
                            require_once(ROOT.'controllers/Panier.php');
                            $controller = new \controllers\Panier();
                            $controller->apiPost(true);
                            break;
                        default:
                            http_response_code(405);
                            echo json_encode(['message' => 'Méthode non autorisée']);
                        break;  
                        
                    }
                break;
                case 'PUT':
                    switch ($params[0]) {
                    case 'articles':
                    case 'categories':
                    case 'benevoles':
                    case 'carrousel':
                    case 'dons':
                    case 'produits':
                    case 'main':
                    case 'catalogue':
                    case 'users':
                        $controller = "\\controllers\\".ucfirst($params[0]);
                        require_once(ROOT.str_replace('\\', DIRECTORY_SEPARATOR, $controller).'.php');
                        $controller = new $controller();
                        if (isset($params[1]) && $params[1] === 'forgot') {
                            $controller->forgot(true);
                        } else {
                            $input = json_decode(file_get_contents('php://input'), true);
                            $this->callControllerAction($controller, $params, 'update', $input);
                        }
                        break;
                    case 'panier':
                        require_once(ROOT.'controllers/Panier.php');
                        $controller = new \controllers\Panier();
                        $controller->apiPut(true);
                        break;
                    default:
                        http_response_code(405);
                        echo json_encode(['message' => 'Méthode non autorisée']);
                    break;  
                    }
                break;
                case 'DELETE':
                    switch ($params[0]) {
                    case 'articles':
                    case 'categories':
                    case 'benevoles':
                    case 'carrousel':
                    case 'dons':
                    case 'produits':
                    case 'main':
                    case 'catalogue':
                    case 'users':
                        $controller = "\\controllers\\".ucfirst($params[0]);
                        require_once(ROOT.str_replace('\\', DIRECTORY_SEPARATOR, $controller).'.php');
                        $controller = new $controller();
                        $id = isset($params[1]) ? $params[1] : null;
                        $this->callControllerAction($controller, $params, 'delete', $id);
                        break;
                    case 'panier':
                        require_once(ROOT.'controllers/Panier.php');
                        $controller = new \controllers\Panier();
                        $controller->apiDelete(true);
                        break;
                    default:
                        http_response_code(405);    
                        echo json_encode(['message' => 'Méthode non autorisée']);    
                    break;  
                
                }
            }
        } else {
            // index des requetes API
            http_response_code(404);
            echo json_encode(['message' => 'Aucune ressource demandée']);
        }
        return "";
    }
            
}
?>