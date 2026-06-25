#!/bin/sh
set -e

mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache
mkdir -p bootstrap/cache

touch storage/database.sqlite
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true

if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

php artisan config:clear
php artisan migrate --force

if [ "${APP_SEED:-false}" = "true" ]; then
    php artisan db:seed --force
fi

exec apache2-foreground
