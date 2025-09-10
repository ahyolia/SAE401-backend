<?php
namespace app;

class ModelFactory {
    public static function create(string $model): ModelInterface {
        $class = "\\models\\" . ucfirst($model);
        $file = ROOT . 'models/' . ucfirst($model) . '.php';
        if (!class_exists($class)) {
            if (file_exists($file)) {
                require_once $file;
            } else {
                throw new \Exception("Fichier du modèle $model introuvable ($file)");
            }
        }
        if (class_exists($class)) {
            return new $class();
        }
        throw new \Exception("Modèle $model introuvable");
    }
}