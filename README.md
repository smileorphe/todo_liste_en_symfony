# 📝 Todo List Symfony

## 🌟 Introduction

Application de gestion de tâches développée avec Symfony, offrant une authentification complète des utilisateurs et des opérations CRUD pour gérer efficacement vos tâches quotidiennes.

Ce projet s'adresse aux :
- 👨‍💻 Développeurs souhaitant explorer une implémentation Symfony
- 🎓 Étudiants apprenant le framework Symfony
- 👔 Recruteurs évaluant les compétences en développement PHP/Symfony

## 🔧 Prérequis

Pour installer et exécuter ce projet, vous aurez besoin de :

- PHP 8.2 ou supérieur
- Composer
- MySQL/MariaDB
- Symfony CLI (optionnel, mais recommandé)
- Navigateur web moderne

## 🚀 Installation

Suivez ces étapes pour installer le projet après l'avoir cloné :

```bash
# Cloner le dépôt
git clone https://github.com/votre-utilisateur/todo-liste-symfony.git
cd todo-liste-symfony

# Installer les dépendances
composer install

# Copier le fichier d'environnement
cp .env .env.local

# Configurer la base de données dans .env.local
# DATABASE_URL="mysql://user:password@127.0.0.1:3306/todo_liste?serverVersion=8.0"

# Créer la base de données
php bin/console doctrine:database:create

# Exécuter les migrations
php bin/console doctrine:migrations:migrate

# Lancer le serveur de développement
symfony serve -d
# ou
php -S localhost:8000 -t public/
```

## 📁 Structure du Code

Le projet est organisé selon l'architecture standard de Symfony :

- **src/Entity/** : Définition des entités
  - `User.php` : Entité utilisateur avec authentification
  - `Task.php` : Entité tâche avec propriétés et relations
  - `TaskPriority.php` : Enum pour les priorités des tâches

- **src/Controller/** : Contrôleurs de l'application
  - `SecurityController.php` : Gestion de l'authentification
  - `RegistrationController.php` : Inscription des utilisateurs
  - `TaskController.php` : CRUD pour les tâches

- **src/Form/** : Formulaires
  - `RegistrationFormType.php` : Formulaire d'inscription
  - `TaskType.php` : Formulaire de création/édition de tâche

- **src/Repository/** : Repositories pour l'accès aux données
  - `UserRepository.php` : Méthodes pour l'entité User
  - `TaskRepository.php` : Méthodes pour l'entité Task avec filtrage et tri

- **src/Security/** : Classes liées à la sécurité
  - `LoginFormAuthenticator.php` : Authentificateur personnalisé
  - `Voter/TaskVoter.php` : Restriction d'accès aux tâches

- **templates/** : Fichiers Twig organisés par entité
  - `base.html.twig` : Template principal avec Bootstrap 5
  - `security/` : Templates d'authentification
  - `task/` : Templates pour la gestion des tâches

- **migrations/** : Fichiers de migrations Doctrine

## ✨ Fonctionnalités

L'application propose les fonctionnalités suivantes :

### 🔒 Authentification
- Inscription avec validation des données
- Connexion sécurisée
- Protection des routes
- Restriction d'accès aux ressources

### 📋 Gestion des tâches
- Création de nouvelles tâches
- Affichage des tâches sous forme de cartes colorées
- Modification des tâches existantes
- Suppression des tâches
- Marquage des tâches comme terminées/à faire

### 🔍 Filtrage et tri
- Filtrage par statut (terminé/à faire)
- Filtrage par priorité (basse, moyenne, haute)
- Filtrage par date d'échéance
- Tri par date de création, priorité ou échéance

### 📊 Interface utilisateur
- Design responsive avec Bootstrap 5
- Cartes de tâches avec code couleur par priorité
- Pagination des résultats
- Notifications par messages flash
- Barre de navigation adaptative

## 🧪 Tests & Débuggage

Commandes utiles pour vérifier le bon fonctionnement de l'application :

```bash
# Valider le schéma de la base de données
php bin/console doctrine:schema:validate

# Afficher les routes disponibles
php bin/console debug:router

# Créer une nouvelle migration après modification des entités
php bin/console make:migration

# Vérifier la configuration de sécurité
php bin/console debug:config security
```

## 🐞 Contribuer

Pour contribuer au projet :

1. Forker le dépôt
2. Créer une branche pour votre fonctionnalité (`git checkout -b feature/amazing-feature`)
3. Commiter vos changements (`git commit -m 'Ajout d'une fonctionnalité'`)
4. Pousser vers la branche (`git push origin feature/amazing-feature`)
5. Ouvrir une Pull Request

Pour signaler un bug, veuillez créer une issue en décrivant :
- Les étapes pour reproduire le bug
- Le comportement attendu
- Le comportement observé
- Captures d'écran si nécessaire

## 📜 Licence

Ce projet est distribué sous la licence MIT. Voir le fichier `LICENSE` pour plus d'informations.

---

Développé avec ❤️ et Symfony
