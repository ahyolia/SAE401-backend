<?php
    namespace controllers; 

    class Articles extends \app\Controller{ 

        /** Cette méthode affiche la liste des articles *
         * @return void */ 
        
         // GET /api/articles
        public function Index(): void {
            $this->loadModel('Articles');
            $articles = $this->Articles->getAll();
            header('Content-Type: application/json');
            echo json_encode($articles);
        }
        
        /** * Méthode permettant d'afficher un article à partir de son slug *
         *  @param string $slug 
         * @return void */ 

        public function lire(string $slug){ 
            $this->loadModel('Articles');
            $article = $this->Articles->findBySlug($slug);
            header('Content-Type: application/json');
            echo json_encode($article);
        }

        public function create(): void {
               if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->loadModel('Articles');
                $data = json_decode(file_get_contents('php://input'), true);
                $result = $this->Articles->create($data);
                header('Content-Type: application/json');
                echo json_encode(['success' => $result]);
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Méthode non autorisée']);
            }
        }

        public function update(int $id): void {
            if ($_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->loadModel('Articles');
            $data = json_decode(file_get_contents('php://input'), true);
            $result = $this->Articles->update($id, $data);
            header('Content-Type: application/json');
            echo json_encode(['success' => $result]);
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Méthode non autorisée']);
            }
        }

        public function delete(int $id): void {
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                $this->loadModel('Articles');
                $result = $this->Articles->delete($id);
                header('Content-Type: application/json');
                echo json_encode(['success' => $result]);
            } else {
                http_response_code(405);
                echo json_encode(['error' => 'Méthode non autorisée']);
            }
        }
        
    }
?>