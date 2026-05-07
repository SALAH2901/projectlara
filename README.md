# Système de Gestion des Rendez-vous Médicaux

Une application robuste développée avec Laravel 12 (mise à jour depuis la v10/v11), conçue pour faciliter la prise de rendez-vous médicaux entre les Médecins et les Patients. Créée dans le cadre d'un projet de fin de module, elle propose une authentification basée sur les rôles, la recherche de médecins, la planification de rendez-vous, une messagerie asynchrone et un système d'évaluation/commentaires, le tout avec un design moderne "Glassmorphism" et un support multilingue (Anglais, Français, Arabe).

## 🚀 Fonctionnalités

- **Accès basé sur les rôles** : Inscription et tableaux de bord sécurisés pour les rôles 'Médecin' et 'Patient' via Laravel Breeze.
- **Recherche de Médecins** : Les patients peuvent parcourir et rechercher des médecins par nom ou spécialité.
- **Prise de Rendez-vous** : Les patients peuvent planifier des rendez-vous avec les médecins en choisissant les dates et heures de leur choix.
- **Gestion des Rendez-vous** : Les médecins peuvent accepter, refuser ou marquer les rendez-vous comme terminés depuis leur tableau de bord. Les patients peuvent annuler les rendez-vous en attente ou acceptés. Les médecins peuvent également bloquer leurs jours d'indisponibilité.
- **Messagerie en temps réel** : Interface de discussion asynchrone permettant aux médecins et patients de communiquer directement une fois le rendez-vous accepté.
- **Système d'évaluation et commentaires** : Les patients peuvent laisser une note (1 à 5 étoiles) et un commentaire pour un médecin après un rendez-vous terminé.
- **Interface Moderne** : Interface entièrement stylisée avec Tailwind CSS et des composants d'interface utilisateur en verre dépoli (Glassmorphism), fluide et responsive (adaptée aux mobiles).
- **Support Multilingue** : Traductions disponibles en Anglais, Français et Arabe (avec prise en charge de l'affichage de droite à gauche - RTL).

## 💻 Stack Technique

- **Framework** : Laravel 12
- **Langage** : PHP 8.2+
- **Base de données** : MySQL
- **Frontend** : Blade Templates, Tailwind CSS, Alpine.js
- **Authentification** : Laravel Breeze

## 🛠️ Instructions d'installation et de configuration

Suivez ces étapes pour installer et lancer l'application localement sur votre machine :


### 1. Installer les dépendances PHP
Assurez-vous d'avoir Composer installé sur votre machine.
```bash
composer install
```

### 2. Installer les dépendances NPM
Assurez-vous d'avoir Node.js et npm installés.
```bash
npm install
```

### 3. Configuration de l'environnement (.env)
- Créez une copie du fichier `.env.example` et nommez-la `.env` :
  ```bash
  cp .env.example .env
  ```
- Générez la clé de l'application :
  ```bash
  php artisan key:generate
  ```
- Ouvrez le fichier `.env` avec votre éditeur de code et configurez vos identifiants de base de données (exemple) :
  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=projectlara
  DB_USERNAME=root
  DB_PASSWORD=
  ```
*(Assurez-vous d'avoir créé au préalable une base de données MySQL nommée `projectlara` ou selon le nom choisi dans votre fichier `.env`).*

### 4. Exécuter les migrations
Créez les tables dans votre base de données en exécutant :
```bash
php artisan migrate
```
*(Optionnel : Vous pouvez exécuter `php artisan migrate --seed` si vous avez des données de test).*

### 5. Créer le lien symbolique pour le stockage
Pour permettre l'accès public aux photos de profil et autres fichiers stockés, exécutez :
```bash
php artisan storage:link
```

### 6. Lancement du projet
Vous aurez besoin de deux fenêtres de terminal exécutées simultanément :

**Terminal 1 (Serveur PHP / Laravel) :**
```bash
php artisan serve
```

**Terminal 2 (Compilation Vite / Tailwind CSS) :**
```bash
npm run dev
```

### 7. Accéder à l'application
Ouvrez votre navigateur web et rendez-vous à l'adresse suivante : `http://localhost:8000`.

## 📖 Guide d'utilisation

1. **Inscription** : Créez deux comptes pour tester le flux de l'application : un en tant que "Médecin" et un autre en tant que "Patient".
2. **Prise de rendez-vous** : Connectez-vous en tant que Patient, cliquez sur "Find a Doctor" (Trouver un médecin), consultez le profil d'un médecin et demandez un rendez-vous selon ses disponibilités.
3. **Gestion** : Connectez-vous en tant que Médecin pour voir la demande entrante dans votre tableau de bord. Cliquez sur "Accept" (Accepter).
4. **Messagerie** : Une fois le rendez-vous accepté, les deux parties verront un bouton "Message" pour discuter entre eux.
5. **Évaluation** : Le médecin peut marquer le rendez-vous comme "Completed" (Terminé). Le patient pourra alors laisser une note (étoiles) et un commentaire.


