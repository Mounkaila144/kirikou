FROM php:8.1-fpm

# Installer les dépendances nécessaires pour PHP et PDO MySQL
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libcurl4-openssl-dev \
    libxml2-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install mysqli pdo pdo_mysql mbstring fileinfo zip curl gd

# Copier le code source de l'application dans le conteneur
COPY . /var/www/html/

# Copier le fichier php.ini dans le répertoire de configuration PHP
COPY ./php.ini /usr/local/etc/php/

# Configurer les permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000

# Commande par défaut pour démarrer PHP-FPM
CMD ["php-fpm"]
