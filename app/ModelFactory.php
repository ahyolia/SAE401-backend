<?php
namespace app;

class ModelFactory {
    public static function create(string $model): ModelInterface {
        $class = "\\models\\" . ucfirst($model);
        if (class_exists($class)) {
            return new $class();
        }
        throw new \Exception("Modèle $model introuvable");
    }
}