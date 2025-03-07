# TodoApp

Bienvenue dans le projet **TodoApp**, une application web permettant de gérer une liste de tâches avec un CRUD basique, ainsi qu'une API REST pour récupérer les tâches en JSON.

## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés sur votre machine :

- **PHP** (version 8.1 ou supérieure)
- **Composer** (outil de gestion des dépendances PHP)
- **MySQL** ou **MariaDB** (ou tout autre SGBD compatible avec Doctrine)
- **Symfony CLI** (facultatif mais recommandé pour le développement local)

## Installation

### 1. Cloner le projet

Commencez par cloner ce repository sur votre machine locale :

```bash
git clone https://github.com/votre-utilisateur/TodoApp.git
cd TodoApp
```

### 2. Installer les dépendances

Installez les dépendances PHP du projet en utilisant Composer :

```bash
composer install
```

### 3. Configurer la base de données

Configurez votre base de données dans le fichier .env ou .env.local. Par exemple :

```bash
DATABASE_URL="mysql://root:@127.0.0.1:3306/todo?serverVersion=8.0.32&charset=utf8mb4"
```
Remarque : Assurez-vous que la base de données todo est déjà créée. Si ce n'est pas le cas, créez-la manuellement dans votre gestionnaire de base de données.

### 4. Créer les tables de la base de données

Générez les migrations de la base de données et appliquez-les pour créer les tables nécessaires :

```bash
php bin/console doctrine:migrations:migrate
```

### 5. Lancer le serveur local

Vous pouvez maintenant démarrer un serveur web local avec Symfony :

```bash
php bin/console server:start
```

Le projet sera accessible sur http://127.0.0.1:8000/task

# Utilisation

## 1. Interface Web

Une fois le serveur lancé, vous pouvez interagir avec l'application via l'interface web :

Page d'accueil : Liste des tâches existantes.
Création de tâches : Ajoutez de nouvelles tâches en cliquant sur "Create a new task".
Modification des tâches : Vous pouvez modifier des tâches existantes.
Suppression de tâches : Vous pouvez supprimer des tâches en utilisant le bouton "Supprimer" avec confirmation.
Marquer les tâches comme terminées : Vous pouvez marquer une tâche comme terminée via un bouton dédié.

## 2. API REST

L'application expose une API REST pour récupérer les tâches en JSON. Pour accéder à cette API, envoyez une requête GET sur l'URL suivante :

http://127.0.0.1:8000/api/tasks

## 3. Filtrage des tâches

Vous pouvez filtrer les tâches selon leur statut (terminé ou non) grâce aux options disponibles dans l'interface web.

Fonctionnalités

- CRUD complet : Créez, lisez, modifiez et supprimez des tâches.
- Marquer comme terminé : Une fois la tâche accomplie, marquez-la comme terminée.
- Filtrage : Affichez les tâches en fonction de leur statut.
- Confirmation avant suppression : Une confirmation est demandée avant de supprimer une tâche.
- API REST : Récupérez les tâches au format JSON via l'API.
