# EPISE – SAE401 (Backend PHP MVC)

Ce dépôt contient le backend du projet EPISE, basé sur un framework MVC en PHP.  
Il gère l’API REST, la base de données, la logique métier et le backoffice administrateur.

---

## Installation

### Prérequis

- PHP >= 7.4
- MySQL/MariaDB
- Serveur Apache ou Nginx
- [WAMP](https://www.wampserver.com/) ou [XAMPP](https://www.apachefriends.org/) recommandé pour Windows

### Étapes

1. **Cloner le dépôt**
   ```sh
   git clone https://github.com/ton-utilisateur/SAE401.git
   ```

2. **Placer le dossier dans le répertoire web**
   - Exemple : `C:\wamp64\www\SAE401` ou `/var/www/html/SAE401`

3. **Créer la base de données**
   - Importer le fichier SQL fourni (`sae401_epise.sql`) dans phpMyAdmin ou via la ligne de commande.

4. **Configurer la connexion MySQL**
   - Modifier `app/Database.php` avec vos identifiants MySQL.

5. **Lancer le serveur**
   - Démarrer Apache et MySQL via WAMP/XAMPP.
   - Accéder à [http://localhost/SAE401](http://localhost/SAE401)

---

## Connexion au Backoffice Administrateur

1. **Accéder au backoffice**
   - Ouvrez [http://localhost/SAE401/backoffice](http://localhost/SAE401/backoffice) dans votre navigateur.

2. **Identifiants administrateur**
   - Utilisez le login et le mot de passe créés dans la table `administrateur` de la base de données.
   - Si aucun administrateur n’existe, ajoutez-en un via phpMyAdmin :
     ```sql
     INSERT INTO administrateur (login, mdp) VALUES ('admin', '<mot_de_passe_hashé>');
     ```
     (Le mot de passe doit être hashé avec `password_hash` en PHP.)

3. **Interface de gestion**
   - Une fois connecté, vous pouvez gérer les articles, produits, catégories, bénévoles, dons, réservations, etc.

---

## Fonctionnalités du backoffice

- Gestion des articles, produits, catégories
- Validation des dons et bénévoles
- Suivi des réservations et adhésions
- Gestion des utilisateurs
- Sécurité par session administrateur

---

## Déploiement

Déployez le dossier sur un hébergement PHP/MySQL compatible.  
Configurez la base de données et les accès selon votre environnement.

---

**Pour toute question, contactez [camhdyo@gmail.com](mailto:camhdyo@gmail.com).**
