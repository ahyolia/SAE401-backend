<?php 
    namespace app; 
    use app\Database;
    
    abstract class Model { 
        protected \mysqli $_connexion;
        public string $table;
        public int $id;

        public function __construct() {
            $this->getConnection();
        }

        public function getConnection(): void {
            $this->_connexion = Database::getInstance()->getConnection();
        }

        public function getOne(): array|bool { 
            $sql = "SELECT * FROM `".$this->table."` WHERE `id`=?"; 
            $stmt = $this->_connexion->prepare($sql);
            $stmt->bind_param("i", $this->id);

            if(!$stmt->execute()) {
                \app\Debug::debugDie(array($stmt->errno,$stmt->error));
                return false;
            }
            $result = $stmt->get_result();
            return $result->fetch_array(MYSQLI_ASSOC);
        }

        public function getAll(): array { 
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

            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $res[] = $row;
            }
            return $res;
        }
    }
?>

