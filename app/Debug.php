<?php 
    namespace app;

    class Debug{
        public static bool $actif = false;
        public static function debug(array $array): void {
        
        if(!self::$actif) return;
            echo "<pre class='debug'>";
            print_r($array);
            echo "</pre>";
        }
        public static function debugDie(array $array): void {
            self::debug($array);
            die();
        }
    }
?>