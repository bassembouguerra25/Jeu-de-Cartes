FROM php:8.2-fpm-alpine

# Installer les dépendances système
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    postgresql-dev \
    icu-dev \
    oniguruma-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libzip-dev \
    nginx

# Installer les extensions PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_pgsql \
        intl \
        mbstring \
        xml \
        zip \
        gd

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Créer l'utilisateur pour l'application
RUN addgroup -g 1000 www && \
    adduser -u 1000 -G www -s /bin/sh -D www

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers de configuration
COPY composer.json composer.lock ./

# Installer les dépendances (sans les scripts post-install pour éviter les erreurs d'environnement)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copier le code source
COPY . .

# Changer les permissions
RUN chown -R www:www /var/www/html

# Configuration nginx
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/default.conf /etc/nginx/conf.d/default.conf

# Exposer le port
EXPOSE 8000

# Script de démarrage
COPY docker/start.sh /start.sh
RUN chmod +x /start.sh

# Commande par défaut
CMD ["/start.sh"] 