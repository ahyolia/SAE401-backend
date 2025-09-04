# Test du Singleton MySQL dans SAE401

Ce fichier permet de vérifier que le design pattern Singleton est bien appliqué à la connexion MySQL dans toute l'application.

## Fichier testé
- `test_singleton.php`

## Prérequis
- PHP >= 7.4
- Serveur MySQL configuré (voir paramètres dans `app/Database.php`)
- Les modèles `Categories`, `Articles`, `Produits` doivent être présents dans le dossier `models/`

## Utilisation
1. Placez le fichier `test_singleton.php` à la racine du projet SAE401.
2. Vérifiez que les fichiers suivants existent et sont bien inclus dans le projet :
   - `app/Database.php`
   - `app/Model.php`
   - `models/Categories.php`
   - `models/Articles.php`
   - `models/Produits.php`
3. Ouvrez un terminal dans le dossier du projet.
4. Exécutez le test :
   ```sh
   php test_singleton.php
   ```

## Ce que le test vérifie
- Que la classe `Database` retourne toujours la même instance (Singleton).
- Que tous les modèles utilisent la même connexion MySQL.
- Qu'une requête simple fonctionne via la connexion du modèle.

## Exemple de sortie attendue
```
Singleton Database OK
Toutes les connexions modèles sont identiques (Singleton OK)
Requête test OK
```

Si un message indique "Singleton FAIL" ou "Requête test FAIL", vérifiez l'implémentation du Singleton et la configuration de la base de données.

## Auteur
- Adapté par GitHub Copilot pour SAE401
