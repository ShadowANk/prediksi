#!/bin/sh
set -e

# Cache configuration & routes
echo "Caching Laravel configuration..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force || true

# Start PHP-FPM in background
php-fpm -D

# Start Nginx in foreground
echo "Starting Nginx..."
exec nginx -g "daemon off;"
