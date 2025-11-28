# 🏥 HospiTime Planner

> Application web de gestion de planning pour le plateau technique de rééducation en Soins Médicaux et de Réadaptation (SMR) du CHU Sébastopol

[![Symfony](https://img.shields.io/badge/Symfony-6.3-000000?style=flat-square&logo=symfony)](https://symfony.com/)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat-square&logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-10.2+-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Doctrine](https://img.shields.io/badge/Doctrine-3.3-F56D00?style=flat-square&logo=doctrine)](https://www.doctrine-project.org/)

---

## 👥 Auteurs

- **Oscar Neveux**
- **Tom Mairet**
- **Allan Laheu**
- **Thibault Martin**
- **Nathan Villette**

---

## 📋 Description du projet

Notre projet porte sur la gestion du planning d'un hôpital, en particulier sur le plateau technique de rééducation en Soins Médicaux et de Réadaptation (SMR) du CHU Sébastopol.

Ce plateau mobilise divers professionnels, comme des kinésithérapeutes, ergothérapeutes, et enseignants en activités physiques adaptées, ainsi que des ressources matérielles et locales spécifiques.

Actuellement, la planification des rendez-vous repose sur un outil Excel, qui, bien que flexible, montre ses limites face à la croissance de l'activité et à la complexité croissante des besoins des patients.

L'objectif principal de ce projet est de concevoir et développer une application web capable de prendre en compte l'ensemble des contraintes des acteurs et des ressources, et d'automatiser efficacement la gestion des plannings.

---

## 🛠️ Technologies utilisées

### Backend

- **[Symfony](https://symfony.com/) 6.3** - Framework PHP moderne et performant
- **[PHP](https://www.php.net/) 8.1+** - Langage de programmation
- **[Doctrine ORM](https://www.doctrine-project.org/) 3.3** - ORM pour la gestion de la base de données
- **[Doctrine DBAL](https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/) 3.x** - Abstraction de base de données
- **[Doctrine Migrations](https://www.doctrine-project.org/projects/doctrine-migrations/en/latest/) 3.3** - Gestion des migrations de base de données

### Frontend

- **[Twig](https://twig.symfony.com/) 2.12/3.0** - Moteur de template
- **[Stimulus](https://stimulus.hotwired.dev/) 3.2** - Framework JavaScript modeste
- **[Turbo](https://turbo.hotwired.dev/) 7.3** - Framework pour les applications web rapides
- **[Symfony Asset Mapper](https://symfony.com/doc/current/frontend/asset_mapper.html)** - Gestion des assets modernes
- **[Bootstrap](https://getbootstrap.com/)** - Framework CSS (via Stimulus)

### Base de données

- **[MySQL/MariaDB](https://www.mysql.com/)** - Système de gestion de base de données relationnelle

### Outils d'administration

- **[EasyAdmin](https://symfony.com/bundles/EasyAdminBundle/current/index.html) 4.18** - Interface d'administration générée automatiquement

### Bibliothèques et outils

- **[dompdf](https://github.com/dompdf/dompdf) 3.0** - Génération de PDF
- **[Symfony Mailer](https://symfony.com/doc/current/mailer.html)** - Envoi d'emails
- **[Symfony Notifier](https://symfony.com/doc/current/notifier.html)** - Notifications
- **[Symfony Security](https://symfony.com/doc/current/security.html)** - Authentification et autorisation
- **[Symfony Forms](https://symfony.com/doc/current/forms.html)** - Gestion des formulaires
- **[Symfony Validator](https://symfony.com/doc/current/validation.html)** - Validation des données
- **[SymfonyCast Verify Email Bundle](https://github.com/SymfonyCasts/verify-email-bundle)** - Vérification d'email

### Tests et qualité de code

- **[Codeception](https://codeception.com/) 5.1** - Framework de tests
- **[PHPUnit](https://phpunit.de/) 9.5** - Framework de tests unitaires
- **[PHP CS Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) 3.64** - Formateur de code PHP
- **[Twig CS Fixer](https://github.com/VincentLanglet/Twig-CS-Fixer) 2.12** - Formateur de code Twig
- **[Zenstruck Foundry](https://github.com/zenstruck/foundry) 1.38** - Factory pour les fixtures

### Développement

- **[Composer](https://getcomposer.org/)** - Gestionnaire de dépendances PHP

---

## 🚀 Installation et configuration

### Prérequis

- PHP 8.1 ou supérieur
- Composer
- Symfony CLI

### Installation de Symfony CLI

```bash
wget https://get.symfony.com/cli/installer -O - | bash
```

### Installation des dépendances

```bash
composer install
```

### Configuration de la base de données

Pour configurer la base de données, il est nécessaire de créer un fichier `.env.local` en copiant le fichier `.env`.

Il est alors nécessaire de mettre en commentaire la configuration actuelle de la base de données et d'utiliser le modèle suivant :

```env
DATABASE_URL="mysql://user:mdp@mysql/bd_name?serverVersion=10.2.25-MariaDB&charset=utf8mb4"
```

### Lancement de l'application

#### Démarrer les services Docker

```bash
docker compose up -d
```

#### Lancer le serveur Symfony

```bash
composer start
```

L'application sera accessible à l'adresse : `http://localhost:8000`

### Initialisation de la base de données

Pour générer la base de données avec les migrations et les fixtures :

```bash
composer db
```

---

## 🔐 Connexion à l'application

Une fois la configuration du projet mise en place et les données factices générées, vous pouvez vous connecter à l'aide des identifiants générés :

### 👤 Patient

- **Email** : `patient@example.com`
- **Mot de passe** : `password`

### 👨‍⚕️ Professionnel de santé

- **Email** : `health_professional@example.com`
- **Mot de passe** : `password`

### 👨‍💼 Administrateur

- **Email** : `admin@example.com`
- **Mot de passe** : `password`

---

## 📜 Scripts disponibles

### 🧹 Qualité de code

#### PHP

- **Afficher les erreurs PHP sans les corriger** :

```bash
composer test:phpcs
```

- **Corriger automatiquement les erreurs PHP** :

```bash
composer fix:phpcs
```

#### Twig

- **Afficher les erreurs Twig sans les corriger** :

```bash
composer test:twigcs
```

- **Corriger automatiquement les erreurs Twig** :

```bash
composer fix:twigcs
```

### 🗄️ Base de données

- **Réinitialiser la base de données** (suppression, création, migrations et fixtures) :

```bash
composer db
```

### 🧪 Tests

- **Nettoyer et lancer les tests Codeception** :

```bash
composer test:codeception
```

- **Lancer tous les tests** (PHP CS, Twig CS et Codeception) :

```bash
composer test
```

---

## 📁 Structure du projet

```
sae3_real_01/
├── assets/              # Assets frontend (JS, CSS, images)
├── bin/                 # Scripts exécutables
├── config/              # Configuration Symfony
├── migrations/          # Migrations Doctrine
├── public/              # Point d'entrée web
├── src/
│   ├── Controller/     # Contrôleurs
│   ├── DataFixtures/   # Fixtures pour les données de test
│   ├── Entity/         # Entités Doctrine
│   ├── Factory/        # Factories Foundry
│   ├── Form/           # Formulaires Symfony
│   ├── Repository/     # Repositories Doctrine
│   └── Security/       # Configuration de sécurité
├── templates/           # Templates Twig
├── tests/              # Tests Codeception
└── var/                # Fichiers temporaires (cache, logs)
```

---

## 📚 Documentation

Pour plus d'informations sur les technologies utilisées :

- [Documentation Symfony](https://symfony.com/doc/6.3/index.html)
- [Documentation Doctrine](https://www.doctrine-project.org/projects/doctrine-orm/en/latest/index.html)
- [Documentation Twig](https://twig.symfony.com/doc/)
- [Documentation Stimulus](https://stimulus.hotwired.dev/)
- [Documentation EasyAdmin](https://symfony.com/bundles/EasyAdminBundle/current/index.html)

---
