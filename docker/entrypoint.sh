#!/bin/sh
set -e

# Support dynamic PORT from Railway (default to 80)
PORT="${PORT:-80}"
echo "Configuring Nginx to listen on port ${PORT}..."
sed -i "s/listen 80;/listen ${PORT};/g" /etc/nginx/http.d/default.conf || true
sed -i "s/listen \[::\]:80;/listen \[::\]:${PORT};/g" /etc/nginx/http.d/default.conf || true

# Ensure storage directories & permissions exist
mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views storage/logs
chmod -R 777 storage bootstrap/cache || true

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

# Start PHP-FPM in background as daemon with root permission (-R)
echo "Starting PHP-FPM..."
php-fpm -D -R

# Wait 1 second and check PHP-FPM process
sleep 1
if ! pgrep php-fpm > /dev/null; then
    echo "Warning: PHP-FPM process check failed!"
fi

# Start Nginx in foreground
echo "Starting Nginx on port ${PORT}..."
exec nginx -g "daemon off;"

