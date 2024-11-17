# SAE 3-01
## Auteurs
Oscar Neveux, Tom Mairet, Allan Laheu, Thibault Martin, Nathan Villette

## Installation et configuration

### Pour exécuter ce projet, il est nécessaire d'installer symfony sur son poste de travaille:
```bash
wget https://get.symfony.com/cli/installer -O - | bash
```

### Puis installer composer sur le projet :
```bash
composer install
```

### Pour lancer le serveur du projet 
```bash
composer start
```

### Liaison à la Base de données
Pour configurer la base de données, il est nécessaire de modifier créer un fichier .env.local en copiant le fichier .env.
Il est alors nécessaire de mettre en commentaire la configuration actuelle de la base de données et d'utiliser le modèle suivant :
```.env.local
DATABASE_URL="mysql://user:mdp@mysql/bd_name?serverVersion=10.2.25-MariaDB&charset=utf8mb4"
```

## Scripts

### Pour maintenir un code propre en PHP et en twig
- Montrer les erreurs des programmes PHP sans les corriger
```shell
composer test:phpcs
```
- Corriger les erreurs des programmes PHP
```shell
composer fix:phpcs
```
- Montrer les erreurs Twig sans les corriger
```shell
composer test:twigcs
```
- Corriger les erreurs Twig
```shell
composer fix:twigcs
```

### Base de données

- Générer la base de donnée :
```shell
composer db
```
