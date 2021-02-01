# WalkInParis 

## Création du projet à partir de Composer & Symfony

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

### création de la bdd walkinparis
```sh
php bin/console doctrine:database:create
```

### Import librarie pour configuration route par annotations
```
composer require annotations
```

### Creation des controllers
```
php bin/console make:controller HomepageController
php bin/console make:controller AgendaController
php bin/console make:controller HowItWorksController
php bin/console make:controller AboutUsController
php bin/console make:controller ContactUsController
```

### Auhtentification et Creation user
https://symfony.com/doc/current/security/form_login_setup.html
```
php bin/console make:auth
php bin/console make:user
php bin/console make:entity Account
```

### Registration form (import en bdd)
https://symfony.com/doc/current/doctrine/registration_form.html
```
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console make:registration-form
```

### Lancer un faux serveur mail:
saisir sur vsc dans votre terminal : 
```
maildev --hide-extensions STARTTLS
```
aller sur votre navigateur : http://localhost:1080


### Initilisation projet (git)
```
echo "# walkinparis" >> README.md
git init
git add README.md
git commit -m "first commit"
git branch -M develop
git remote add origin https://github.com/Badawane/walkinparis.git
git push -u origin develop
```
