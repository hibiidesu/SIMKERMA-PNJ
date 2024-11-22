#!/bin/bash
set -e

echo "Entrypoint script is running"
date

service nginx start
DB_HOST=${DB_HOST:-db}
DB_PORT=${DB_PORT:-5432}

echo "DB_HOST: $DB_HOST"
echo "DB_PORT: $DB_PORT"

echo "Waiting for the database to be ready..."
until nc -zv $DB_HOST $DB_PORT; do
    echo "Still waiting for the database at $DB_HOST:$DB_PORT..."
    sleep 2
done
echo "Database is ready!"

FIRST_RUN_FILE="/var/www/.first_run_completed"

if [ ! -f "$FIRST_RUN_FILE" ]; then
    echo "First run! Installing dependencies, migrating, and seeding the database..."
    cd /var/www

    composer install --no-dev --optimize-autoloader

    chown -R www-data:www-data /var/www
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

    echo "Running migrations..."
    php artisan migrate --force

    echo "Running seeders..."
    php artisan db:seed --force

    touch "$FIRST_RUN_FILE"

    echo "First-time setup completed!"
else
    echo "Not the first run. Skipping setup."
fi

# Start PHP-FPM
php-fpm
