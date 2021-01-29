# WalkInParis 

## 1. Installation à partir de Git
1/ Dans votre repertoire www des projets, taper les 3 commandes suivantes dans le terminal vscode dans le repertoire www
```sh
git clone https://github.com/Badawane/walkinparis.git
cd walkinparis
composer install
npm install -g maildev
```


2/ Ouvrir le projet sur vscode, il faut copier le fichier .env ->  .env.local et le completer avec les 2 variables suivantes :
(A adapter suivant vos config de connexion a votre base de données.)
```sh
MAILER_URL=smtp://localhost:1025
DATABASE_URL="mysql://root:@127.0.0.1:3306/walkinparis
```

3/ faire la migration des tables de données
```sh
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

4/ Puis lancer les servers dans 2 consoles différentes:

terminal 1
```sh
php bin/console server:run
```
terminal 2
```sh
maildev --hide-extensions STARTTLS
```

le server mail est accessible à l'addresse depuis un navigateur : http://localhost:1025


## 2. Mise à jour à partir de Git
```sh
git pull
php bin/console doctrine:migrations:migrate
```


## 0. Création du projet à partir de Composer & Symfony

Pour mémoire, ci-après le étapes pour créer le projet symfony.
En se placant dans le répertoire de votre serveur web (exemple: www)

<!-- Installation -->
```sh
composer create-project symfony/website-skeleton walkinparis "4.4.*"
cd walkinparis
composer require server --dev
php bin/console server:run 
# (OR with symfony-cli: symfony serve)

composer require profiler --dev
```

Il faut dupliquer le fichier .env en .env.local et paramatrer les 2 variables suivantes :
```sh
DATABASE_URL="mysql://root:@127.0.0.1:3306/walkinparis"
MAILER_URL=smtp://localhost:1025
```

création de la bdd walkinparis
php bin/console doctrine:database:create

configuration route par annotations
composer require annotations

creation de controller
php bin/console make:controller HomepageController
php bin/console make:controller AgendaController
php bin/console make:controller HowItWorksController
php bin/console make:controller AboutUsController
php bin/console make:controller ContactUsController

<!-- creation user -->
php bin/console make:user
php bin/console make:entity Account

registration form (import en bdd)
https://symfony.com/doc/current/doctrine/registration_form.html
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console make:registration-form

lancer un faux serveur mail:
saisir sur vsc dans votre terminal : maildev --hide-extensions STARTTLS
aller sur votre navigateur : localhost:1025


initilisation projet (git)
echo "# walkinparis" >> README.md
git init
git add README.md
git commit -m "first commit"
git branch -M develop
git remote add origin https://github.com/Badawane/walkinparis.git
git push -u origin develop
