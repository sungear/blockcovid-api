# API BlockCovid

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

## Installer Lumen 8 et PHP 8
https://lumen.laravel.com/docs/8.x

https://www.php.net/downloads

## Installer les dépendances du fichier composer.json
```
composer install
```

## Mettre en place l'environnement
1) Créer un fichier .env
2) Copier/coller le contenu de env.example dans .env

## Connecter à une base de données
### En localhost
1) Créer une base de donnée dans PgAdmin
2) Importer le fichier blockcovid\database\db.sql dans le query tools de pgadmin et exécuter
3) Vérifier que le support de l'extension pdo_pgsql est activée
```
php -m
```
4) Si le pdo_pgsql n'est pas dans la liste, il faut ouvrir php.ini et décommenter les lignes suivantes :
```
;extension=pdo_pgsql
;extension=pgsql
```
5) Dans le fichier .env, remplacer les valeurs telles que : 
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=le port de votre base de données
DB_DATABASE=le nom que vous avez choisi pour votre base de données
DB_USERNAME=postgres
DB_PASSWORD=le mot de passe que vous aviez choisi pour votre serveur si y en a un
```
6) Pour servir l'app en localhost sur le port 8000
```
composer start
```
### Accéder à la base de données Heroku à partir de PgAdmin
Créer un serveur avec :
```
Host name/adsress = ec2-54-247-103-43.eu-west-1.compute.amazonaws.com
Port = 5432
Maintenance database = d1kjecmsefvdrm
Username = amunbiarsdeewa
Password = 2e1f2bc5e21aa7a351bc9e64cc6f7f493502c0f802b3593cfd751c15f84093e7
```
N'oubliez pas de cocher "Save password?" et de mettre "Require" pour le SSL mode dans le tab SSL.
Si vous ne voulez voir que la DB de l'API dans PgAdmin, allez dans le tab Advanced et indiquez :
```
DB restriction = d1kjecmsefvdrm
```
N'utilisez cette DB que pour tester les pipelines !

## Accéder aux pipelines
API : https://g10-blockcovid-api-staging.herokuapp.com/api/

PWA Staging : https://blockcovid-pwa-staging.herokuapp.com/

PWA Production : https://blockcovid-pwa.herokuapp.com/

## Les Routes
### URL de base
Pour connecter à l'API en localhost, créer un fichier .env.local à la racine du projet Vue et ajouter :
```
VUE_APP_API_URL=http://localhost:8000/api
```
Pour connecter à l'API sur Heroku, créer un fichier .env.local à la racine du projet Vue et ajouter :
```
VUE_APP_API_URL=https://g10-blockcovid-api-staging.herokuapp.com/api
```
### Citoyens
Scanner un QR code
```
post: citoyens/qr_code
```
Générer un id unique
```
get: citoyens/enregistrement
```
### Medecins
S'inscrire
```
post: medecins/inscription
```
Connexion
```
post: connexion
```
Générer un QR code
```
post: medecins/qr_code
```
### Etablissements
S'inscrire
```
post: etablissements/inscription
```
Connexion
```
post: connexion
```
Générer un QR code
```
post: etablissements/qr_code
```