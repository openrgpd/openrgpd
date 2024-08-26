# Utiliser l'image PHP 7.4 avec Apache
FROM php:7.4-apache

# Installer les dépendances système requises pour Composer
RUN apt-get update && apt-get install -y \
    unzip \
    && apt-get clean 


# Ajout de composer
COPY --from=composer/composer:2.7-bin /composer /usr/bin/composer


# Installer l'extension pdo_mysql
RUN docker-php-ext-install pdo pdo_mysql

COPY composer.json composer.lock /var/www/html/

# Copier le code source dans le conteneur
COPY ./app /var/www/html/

WORKDIR /var/www/html/

RUN composer install

# Exposer le port 80
EXPOSE 80
