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

le server mail est accessible à l'addresse depuis un navigateur : http://localhost:1080


## 2. Mise à jour à partir de Git
```sh
git pull
php bin/console doctrine:migrations:migrate
```
