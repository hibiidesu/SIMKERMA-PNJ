#!/bin/bash
set -e

echo "Entrypoint script is running"
date

# Set PHP configuration from environment variables
if [ ! -z "$PHP_MEMORY_LIMIT" ]; then
    sed -i "s/memory_limit = .*/memory_limit = $PHP_MEMORY_LIMIT/" /usr/local/etc/php/conf.d/custom-php.ini
    echo "PHP memory limit set to $PHP_MEMORY_LIMIT"
fi

if [ ! -z "$PHP_UPLOAD_MAX_FILESIZE" ]; then
    sed -i "s/upload_max_filesize = .*/upload_max_filesize = $PHP_UPLOAD_MAX_FILESIZE/" /usr/local/etc/php/conf.d/custom-php.ini
    echo "PHP upload max filesize set to $PHP_UPLOAD_MAX_FILESIZE"
fi

if [ ! -z "$PHP_POST_MAX_SIZE" ]; then
    sed -i "s/post_max_size = .*/post_max_size = $PHP_POST_MAX_SIZE/" /usr/local/etc/php/conf.d/custom-php.ini
    echo "PHP post max size set to $PHP_POST_MAX_SIZE"
fi

service nginx start
export $(grep -v '^#' .env | xargs)

# Validate essential environment variables
if [[ -z "$DB_HOST" || -z "$DB_PORT" || -z "$DB_USERNAME" || -z "$DB_DATABASE" ]]; then
    echo "ERROR: Missing essential database environment variables. Check your .env file."
    exit 1
fi
echo "DB_HOST: $DB_HOST"
echo "DB_PORT: $DB_PORT"

echo "Waiting for the database to be ready..."
timeout=60
start_time=$(date +%s)
while ! nc -z $DB_HOST $DB_PORT; do
    current_time=$(date +%s)
    elapsed=$((current_time - start_time))
    if [ $elapsed -ge $timeout ]; then
        echo "ERROR: Timed out waiting for database after ${timeout} seconds"
        exit 1
    fi
    echo "Still waiting for the database at $DB_HOST:$DB_PORT..."
    sleep 2
done
echo "Database is ready!"

FIRST_RUN_FILE="/var/www/.first_run_completed"

if [ ! -f "$FIRST_RUN_FILE" ]; then
    echo "First run! Installing dependencies, migrating, and seeding the database..."
    cd /var/www

    composer install --no-dev --optimize-autoloader
    if [ $? -ne 0 ]; then
        echo "ERROR: Composer install failed"
        exit 1
    fi

    composer require chillrend/pnj-socialite-provider
    if [ $? -ne 0 ]; then
        echo "ERROR: Failed to require chillrend/pnj-socialite-provider"
        exit 1
    fi

    chown -R www-data:www-data /var/www
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

    echo "Running migrations..."
    php artisan migrate --force
    if [ $? -ne 0 ]; then
        echo "ERROR: Database migration failed"
        exit 1
    fi

    echo "Running seeders..."
    php artisan db:seed --force
    if [ $? -ne 0 ]; then
        echo "ERROR: Database seeding failed"
        exit 1
    fi

    touch "$FIRST_RUN_FILE"

    echo "First-time setup completed successfully!"
else
    echo "Not the first run. Skipping setup."
fi

echo "Starting PHP-FPM..."
exec php-fpm
