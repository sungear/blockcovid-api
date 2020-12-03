# API BlockCovid

[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://img.shields.io/packagist/v/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://img.shields.io/packagist/l/laravel/framework)](https://packagist.org/packages/laravel/lumen-framework)

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