#!/bin/bash
set -e

echo "Entrypoint script is running"
date

service nginx start
export $(grep -v '^#' .env | xargs)

# Validate essential environment variables
if [[ -z "$DB_HOST" || -z "$DB_PORT" || -z "$DB_USERNAME" || -z "$DB_DATABASE" ]]; then
    echo "Missing essential database environment variables. Check your .env file."
    exit 1
fi
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
