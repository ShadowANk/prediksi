#!/bin/sh
set -e

# Support dynamic PORT from Railway (default to 80)
PORT="${PORT:-80}"
echo "Configuring Nginx to listen on port ${PORT}..."
sed -i "s/listen 80;/listen ${PORT};/g" /etc/nginx/http.d/default.conf || true
sed -i "s/listen \[::\]:80;/listen \[::\]:${PORT};/g" /etc/nginx/http.d/default.conf || true

# Clear previous caches first to prevent stale configs
php artisan config:clear || true

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
echo "Starting Nginx on port ${PORT}..."
exec nginx -g "daemon off;"

