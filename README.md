# WalkInParis 

<!-- Installation -->
----
composer create-project symfony/website-skeleton walkinparis "4.4.*"
cd walkinparis
composer require server --dev
php bin/console server:run (OR with symfony-cli: symfony serve)

composer require profiler --dev

```

<!-- création de la bdd walkinparis -->
creation d'un fichier .env.local qui contient données sensibles (ne sera pas commit)
ajouter ligne DATABASE_URL="mysql://root:@127.0.0.1:3306/walkinparis"
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
maildev --hide-extensions STARTTLS


initilisation projet (git)
echo "# walkinparis" >> README.md
git init
git add README.md
git commit -m "first commit"
git branch -M develop
git remote add origin https://github.com/Badawane/walkinparis.git
git push -u origin develop