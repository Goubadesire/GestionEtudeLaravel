# Base PHP avec extensions nécessaires
FROM php:8.3-cli

# Installer les dépendances systèmes
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git mariadb-client \
    && docker-php-ext-install pdo_mysql zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /app
COPY . /app

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Générer la clé Laravel
RUN php artisan key:generate

# Exposer le port que Railway utilisera
EXPOSE 8080

# Commande pour démarrer Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
