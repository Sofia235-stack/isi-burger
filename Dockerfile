# Dockerfile
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libzip-dev \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    npm \
    zip

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql zip mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install NPM dependencies and build assets
RUN npm install && npm run build

# Set permissions (optionnel selon ton projet)
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Cache configuration
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Start PHP-FPM server
CMD ["php-fpm"]
