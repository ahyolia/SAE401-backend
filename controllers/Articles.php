<?php
    namespace controllers; 
    use app\ModelFactory;

    class Articles extends \app\Controller{ 
        protected $articlesModel;
        public function __construct() {
            $this->articlesModel = ModelFactory::create('Articles');
        }


        /** Cette méthode affiche la liste des articles *
        * @return void */ 
        public function index($api=false): mixed{
            $this->loadModel('Articles');
            $articles = $this->Articles->getAll();
            if ($api) {
                header('Content-Type: application/json');
                echo json_encode($articles);
                return null;
            }
            return $this->render('index', compact('articles'), $api); 
        }
        

        /** * Méthode permettant d'afficher un article à partir de son slug *
         *  @param string $slug 
         * @return void */ 
        public function lire(string $slug, $api = false){ 
            $this->loadModel('Articles');
            $article = $this->Articles->findBySlug($slug);
            if ($api) {
                header('Content-Type: application/json');
                echo json_encode($article);
                return null;
            }
            $this->render('lire', compact('article'));
        }


        public function create($api = false): void {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->loadModel('Articles');
                $data = $_POST;
                if (empty($data)) {
                    $data = json_decode(file_get_contents('php://input'), true);
                }
                try {
                    $message = $this->Articles->create($data);
                    if ($api) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true, 'message' => $message]);
                        return;
                    }
                    echo $message;
                } catch (\Throwable $e) {
                    if ($api) {
                        http_response_code(400);
                        echo json_encode(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
                        return;
                    }
                    echo 'Erreur : ' . $e->getMessage();
                }
            } else {
                $this->render('create');
            }
        }


        public function update(int $id, $api = false): void {
            $this->loadModel('Articles');
            $this->loadModel('Categories');
            $data = $_POST;
            if (empty($data)) {
                $data = json_decode(file_get_contents('php://input'), true);
            }
            if ($_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    $message = $this->Articles->update($id, $data);
                    $bo = [
                        'msg' => $message,
                        'articles' => $this->Articles->getAll(),
                        'categories' => $this->Categories->getAll()
                    ];
                    if ($api) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true, 'message' => $message]);
                        return;
                    }
                    $this->render('Articles', compact('bo'));
                } catch (\Throwable $e) {
                    if ($api) {
                        http_response_code(400);
                        echo json_encode(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
                        return;
                    }
                    echo 'Erreur : ' . $e->getMessage();
                }
            } else {
                $article = $this->Articles->getById($id);
                $categories = $this->Categories->getAll();
                $bo = [
                    'article' => $article,
                    'categories' => $categories
                ];
                $this->render('update', compact('bo'));
            }
        }


        public function delete(int $id, $api = false): void {
            $this->loadModel('Articles');
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE' || $_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    $message = $this->Articles->delete($id);
                    if ($api) {
                        header('Content-Type: application/json');
                        echo json_encode(['success' => true, 'message' => $message]);
                        return;
                    }
                    echo $message;
                } catch (\Throwable $e) {
                    if ($api) {
                        http_response_code(400);
                        echo json_encode(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
                        return;
                    }
                    echo 'Erreur : ' . $e->getMessage();
                }
            } else {
                $article = $this->Articles->getById($id);
                $this->render('delete', compact('article'));
            }
        }
        
    }
?>