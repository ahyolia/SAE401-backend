<?php 
    namespace app; 
    abstract class Model { 
        // Informations de la base de données
        private string $host = "localhost"; 
        private string $db_name = "sae401_epise"; 
        private string $username = "root"; 
        private string $password = ""; 
        
        // Propriété qui contiendra l'instance de la connexion 
        protected \mysqli $_connexion;
        
        // Propriétés permettant de personnaliser les requêtes 
        public string $table; 
        public int $id;

        public function __construct() {
        $this->getConnection();
        }

        /** 
         * * Fonction d'initialisation de la base de données * 
         * * @return void */ 

        public function getConnection() : void { 
            // On essaie de se connecter à la base de données
            try{ 
                $this->_connexion = new \mysqli($this->host, $this->username, $this->password, $this->db_name); 
                $this->_connexion->set_charset("utf8"); 
            }
            catch(\mysqli_sql_exception $exception){ 
                echo "Erreur de connexion : " . $exception->getMessage(); 
            }
        } 

        /**
        * Méthode permettant d'obtenir un enregistrement de la table choisie en fonction d'un id
        *
        * @return array|bool
        */
        
        //stmt = l'objet qui va contenir la requête préparée
        public function getOne(): array|bool { 
            $sql = "SELECT * FROM `".$this->table."`WHERE `id`=?"; 
            $stmt = $this->_connexion->prepare($sql);
            $stmt->bind_param("i", $this->id);

            if(!stmt->execute()) {
                \app\Debug::debugDie(array($stmt->errno,$stmt->error));
                return false;
            }
            $result = $stmt->get_result();
            return $result->fetch_array(MYSQLI_ASSOC);
        }
            
        /** 
         * Méthode permettant d'obtenir 
         * tous les enregistrements de la table choisie *
         * @return array */ 

        public function getAll(): array{ 
            $sql = "SELECT * FROM `{$this->table}`"; 
            $stmt = $this->_connexion->prepare($sql);
            
            if(!$stmt) {
                \app\Debug::debugDie(array($stmt->errno,$stmt->error));
                return false;
            }
            if(!$stmt->execute()) {
                \app\Debug::debugDie(array($stmt->errno,$stmt->error));
                return false;
            }

            $result = $stmt->get_result();
            $res = array();

            while($row=$result->fetch_array(MYSQLI_ASSOC)) {
             $res[]=$row;
            }
            return $res;
        }
                
        
    }
?>

