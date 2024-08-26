# Utiliser l'image PHP 7.3 avec Apache
FROM php:7.3-apache

# Installer l'extension pdo_mysql
RUN docker-php-ext-install pdo pdo_mysql

# Copier le code source dans le conteneur
COPY ./app /var/www/html/

# Exposer le port 80
EXPOSE 80
