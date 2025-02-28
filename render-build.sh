#!/usr/bin/env bash

# Installer PHP et les extensions nécessaires
apt-get update && apt-get install -y php-cli php-mbstring php-xml unzip curl

# Installer Composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installer les dépendances
composer install --no-dev --optimize-autoloader

# Exécuter les migrations
php artisan migrate --force

# Clear et cache la configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
