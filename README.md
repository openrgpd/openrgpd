# openrgpd
 Outil permettant de se mettre plus facilement en conformité avec la réglementation RGPD de 2016

## Lancement via docker compose

docker compose se base sur le fichier docker-compose.yml à la racine du projet. Le mot de passe mysql root, ainsi que le nom du user mysql et son mot de passe (qui seront utilisés pour se connecter à la base) sont à renseigner dans ce fichier docker-compose.yml.
Le nom du user et son mot de passe doivent aussi être renseignés dans config.php. S'il n'existe pas, d'abord le copier:
```bash
cp config.sample.php config.php
```


* Pour lancer l'application : 
```bash
docker compose up --build -d
```
* Se connecter à la base de données mysql avec l'utilisateur root. Le plus simple est d'installer un client mysql sur le host et de se connecter en spécifiant le port mysql mappé sur le host (ici 30403)

```bash
mysql -u root -p<PASSWORD> -P 30403
```
* une fois connecté, ajouter les droits à l'utilisateur (remplacer 'my_user' par le user renseigné dans config.php et dans le docker-compose.yml)
```bash
use openrgpd
GRANT ALL PRIVILEGES ON openrgpd.* TO 'my_user'@'%' IDENTIFIED BY 'my_password';
``` 

* Utiliser le fichier openrgpd.sql pour initialiser la BDD dans le mariadb installé
```bash
mysql -u root -p<PASSWORD> -P 30403 openrgpd < openrgpd.sql
```

* Ouvrir l'application avec votre navigateur (port 30401) et se connecter avec ADMIN / OpenRGPD@1 pour la 1ère connexion.


## Lancement sur VM

### Pré-requis : 
* installer [Composer](https://getcomposer.org/doc/00-intro.md)

###  Installer les dépendances
L'application utilise une librairie de génération de pdf. Pour l'installer : 

```bash
composer install
```




 ### En cas de 1ère installation complète (en prod):
* Copier-coller dans le dossier html du serveur l'ensemble du dossier
* Utiliser le fichier openrgpd.sql pour créer une base de données "openrgpd" avec mysql.
* Copier le fichier ``config.sample.php`` dans le répertoire **parent** de l'application. Ce dossier ne doit pas être accessible du web. Renommer le fichier en ``config.php``
* Modifier le fichier ``config.php``  en ajoutant  vos informations de connexions ainsi que le mail à utiliser pour l'envoi des messages.
* Ouvrir l'application avec votre navigateur et se connecter avec ADMIN / OpenRGPD@1 pour la 1ère connexion.*

### Dans le cas d'une MAJ uniquement :
* Copier-coller dans le dossier html du serveur l'ensemble du dossier
* Ouvrir le fichier versionSQL.txt et lancer le ou les update SQL correspondants à votre version.

Pour mariadb 10.2/10.3/10.4 nécessité d'ajouter cette ligne dans le fichier my.cnf de mariadb pour linux ou my.ini pour windows:
``sql-mode = ''``
Il est conseillé d'utiliser une version php 7.0/7.1/7.2/7.3
