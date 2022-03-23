# openrgpd
 Outil permettant de se mettre plus facilement en conformité avec la réglementation RGPD de 2016

 ### En cas de 1ère installation complète :
* Copier-coller dans le dossier html du serveur l'ensemble du dossier
* Utiliser le fichier openrgpd.sql pour créer une base de données "openrgpd" avec mysql.
* Modifier le fichier connexion/connexion.php en ajoutant  vos informations de connexions.
* Ouvrir l'application avec votre navigateur et se connecter avec ADMIN / OpenRGPD@1 pour la 1ère connexion.*

### Dans le cas d'une MAJ uniquement :
* Copier-coller dans le dossier html du serveur l'ensemble du dossier
* Ouvrir le fichier versionSQL.txt et lancer le ou les update SQL correspondants à votre version.

Pour mariadb 10.2/10.3/10.4 nécessité d'ajouter cette ligne dans le fichier my.cnf de mariadb pour linux ou my.ini pour windows:
``sql-mode = ''``
Il est conseillé d'utiliser une version php 7.0/7.1/7.2/7.3
