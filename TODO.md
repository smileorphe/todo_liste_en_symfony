# Liste de Tâches - Projet Symfony

## Suivi du Projet

## Étapes à suivre

### 1. Configuration du projet 💻
- [x] Initialisation du projet Symfony
- [x] Configuration de la base de données
- [x] Installation des dépendances
  - [x] symfony/security-bundle
  - [x] symfony/form
  - [x] doctrine/orm
  - [x] doctrine/doctrine-bundle
  - [x] symfony/maker-bundle
  - [x] Bootstrap 5 (via CDN)
  - [x] Font Awesome (via CDN)

### 2. Gestion des Utilisateurs 👤
- [x] Création de l'entité Utilisateur
  - [x] Implémentation des interfaces UserInterface et PasswordAuthenticatedUserInterface
  - [x] Champs : email, mot de passe, roles
- [x] Système d'authentification
  - [x] Formulaire de connexion
  - [x] Formulaire d'inscription
  - [x] Protection des routes
  - [x] Authentificateur personnalisé
  - [x] Configuration security.yaml

### 3. Gestion des Tâches 📝
- [x] Création de l'entité Tâche
  - [x] Champs obligatoires :
    - [x] titre (chaîne de caractères)
    - [x] statut de complétion (booléen, défaut: faux)
    - [x] priorité (enum : Basse, Moyenne, Haute)
  - [x] Champs optionnels :
    - [x] description (texte)
    - [x] date d'échéance (datetime)
  - [x] Relation avec l'utilisateur (ManyToOne)
- [x] Voter de sécurité pour restreindre l'accès aux tâches

### 4. Interface Utilisateur 🎨
- [x] Template principal
- [x] Barre de navigation responsive
- [x] Page liste des tâches
  - [x] Affichage des tâches sous forme de cartes
  - [x] Code couleur selon la priorité
  - [x] Pagination
- [x] Formulaires
  - [x] Création de tâche
  - [x] Modification de tâche

### 5. Fonctionnalités CRUD 💾
- [x] Création du contrôleur de tâches
- [x] Implémentation des opérations CRUD
  - [x] Création
  - [x] Lecture
  - [x] Mise à jour
  - [x] Suppression
- [x] Validation des données
- [x] Protection CSRF

### 6. Fonctionnalités avancées ✨
- [x] Filtrage des tâches
  - [x] Par statut (terminé/à faire)
  - [x] Par priorité
  - [x] Par date d'échéance
- [x] Tri des tâches
  - [x] Par date de création
  - [x] Par priorité
  - [x] Par date d'échéance

## Fonctionnalités implémentées

- **Authentification complète** : Inscription, connexion, déconnexion
- **Gestion des tâches** : Création, affichage, modification, suppression
- **Interface utilisateur** : Design responsive avec Bootstrap 5 et Font Awesome
- **Sécurité** : Protection CSRF, validation des données, restriction d'accès aux tâches
- **Filtrage et tri** : Filtrage par statut, priorité, date d'échéance et tri par différents critères
- **Pagination** : Affichage des tâches par pages
- **Notifications** : Messages flash pour les actions réussies/échouées

## Problèmes en cours 🚧
- [ ] Résoudre les conflits de dépendances entre doctrine-bundle et maker-bundle
