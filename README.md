[![Maintainability](https://api.codeclimate.com/v1/badges/f68a16c419c5a317ba6a/maintainability)](https://codeclimate.com/github/Kzhiti/Projet7/maintainability)

# Projet7 - BileMo

## Environnement utilisé durant le développement
* Symfony 5.3.2
* Composer 2.0.9
* WampServer 3.2.3
    * Apache 2.4.46
    * PHP 7.4.9
    * MySQL 5.7.31

## Installation
1. Clonez ou téléchargez le repository GitHub dans le dossier voulu :
```
    git clone https://github.com/Kzhiti/Projet7
```
2. Configurez vos variables d'environnement tel que la connexion à la base de données dans le fichier `.env.local` qui devra être crée à la racine du projet en réalisant une copie du fichier `.env`.

3. Téléchargez et installez les dépendances du projet avec Composer :
```
    composer install
```
4. Créez la base de données si elle n'existe pas déjà, taper la commande ci-dessous en vous plaçant dans le répertoire du projet :
```
    php bin/console doctrine:database:create
```
5. Créez les différentes tables de la base de données en appliquant les migrations :
```
    php bin/console doctrine:migrations:migrate
```
6. Générez les clés SSH
Et noter votre passphrase à la ligne "JWT_PASSPHRASE=" de votre fichier `.env.local`
```bash
$ mkdir config/jwt
$ php bin/console lexik:jwt:generate-keypair
```
7. (Optionnel) Installez les fixtures pour avoir un jeu de données :
```
    php bin/console doctrine:fixtures:load
```
8. Le projet est installé correctement, vous pouvez désormais commencer à l'utiliser !