FROM php:8.3-fpm-alpine

# Install system dependencies & Nginx
RUN apk add --no-cache \
    nginx \
    curl \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    oniguruma-dev \
    nodejs \
    npm

# Install PHP extensions required by Laravel & MySQL
RUN docker-php-ext-install pdo pdo_mysql bcmath zip opcache

# Copy Composer binary from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy repository files
COPY . .

# Install PHP dependencies for production
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install NPM dependencies & build production frontend assets
RUN npm install --ignore-scripts
RUN npm run build

# Copy custom Nginx configuration
COPY docker/nginx.conf /etc/nginx/http.d/default.conf

# Set permissions for Laravel storage & cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Make entrypoint script executable
RUN chmod +x docker/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker/entrypoint.sh"]
