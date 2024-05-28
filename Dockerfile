# image PHP officielle
FROM php:7.4-apache

# les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# les fichiers de l'application dans le répertoire de l'image Docker
COPY . /var/www/html/

#le répertoire de travail
WORKDIR /var/www/html/

# le port sur lequel Apache écoute
EXPOSE 80

# Démarrage Apache
CMD ["apache2-foreground"]
