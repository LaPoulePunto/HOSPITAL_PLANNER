# SAE 3-01 - HOSPITIME
## Auteurs
**Oscar Neveux** (neve0044)\
**Tom Mairet** (mair0032)\
**Allan Laheu** (lahe0010)\
**Thibault Martin** (mart0495)\
**Nathan Villette** (vill0127)

## Voir le projet

Le projet est disponible à l'adresse suivante (avec le vpn activé):\
[Hospitime lien](http://10.31.33.118:8000/)

La machine virtuelle contenant le serveur est accessible en ssh :\
**IP** : 10.31.33.118\
**Utilisateur** : user\
**Mot de passe** : user

Le serveur tourne sur un screen :\
Voir les screens actifs:
````shell
screen -ls
````

Aller sur le screen du serveur :
````shell
screen -r 13796.sae
````

Pour se détacher du screen :\
ctrl + a puis d

## Installation et configuration

### Pour exécuter ce projet, il est nécessaire d'installer symfony sur son poste de travail :
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
Pour configurer la base de données, il est nécessaire de créer un fichier .env.local en copiant le fichier .env.
Il est alors nécessaire de mettre en commentaire la configuration actuelle de la base de données et d'utiliser le modèle suivant :
```.env.local
DATABASE_URL="mysql://user:mdp@mysql/bd_name?serverVersion=10.2.25-MariaDB&charset=utf8mb4"
```

### Se connecter à la base de données
Une fois la configuration du projet mise en place et les données factices générées, vous pouvez vous connecter soit
à l'aide des identifiants générés pour cela :
- Pour se connecter en tant que Patient :
  - email : patient@example.com
  - mot de passe : password
- Pour se connecter en tant que HealthProfessional :
  - email : health_professional@example.com
  - mot de passe : password

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

### Test Codeception

- Pour nettoyer le répertoire « _output » et le code généré par Codeception. Puis lancer les tests de Codeception
```shell
composer test:codeception
```

- Pour tester la mise en forme du code PHP, Twig et lancer le script composer des tests avec Codeception (ci-dessus)
```shell
composer test
```