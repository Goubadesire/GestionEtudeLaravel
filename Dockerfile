# Étape 1 : image PHP avec extensions nécessaires
FROM php:8.3-cli

# Installer les dépendances et extensions PHP
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libzip-dev \
    mariadb-client \
    && docker-php-ext-install pdo_mysql zip

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /app

# Copier le projet
COPY . /app

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Copier le .env.example comme .env pour le build
COPY .env.example .env

# Générer la clé Laravel
RUN php artisan key:generate

# Exposer le port que Railway utilisera
EXPOSE 8000

# Commande pour démarrer Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
