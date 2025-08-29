<?php 
namespace controllers; 

    class Main extends \app\Controller{ 
        /** 
         * Cette méthode affiche la page principale * 
         * @return void */ 
        
        public function index(): void { 
            $this->loadModel('Articles');
            $articles = $this->Articles->getAll(); // Remplace findAll() par getAll()
            $mainArticle = null;
            $sideArticles = [];
            foreach ($articles as $article) {
                if (!empty($article['is_main']) && !$mainArticle) {
                    $mainArticle = $article;
                } else {
                    $sideArticles[] = $article;
                }
            }
            $this->loadModel('Carrousel');
            $carrouselPartenaires = $this->Carrousel->getByCategorie('partenaires');
            // On envoie les données à la vue index 
            $this->render('index', compact('mainArticle', 'sideArticles', 'carrouselPartenaires'));
        } 
    } 
?>