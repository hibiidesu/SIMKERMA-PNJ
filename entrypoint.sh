#!/bin/bash
set -e

echo "Entrypoint script is running"
date

# Start Nginx
service nginx start
# Start PHP-FPM
php-fpm &
echo "Nunggu koneksi DB"
sleep 10

FIRST_RUN_FILE="/var/www/.first_run_completed"

if [ ! -f "$FIRST_RUN_FILE" ]; then
    echo "First run! memulai install composer, seeding dan migrate"
    cd /var/www
    ls /var/www
    composer install --no-dev --optimize-autoloader

    chown -R www-data:www-data /var/www
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache


    php artisan migrate --force --pretend || php artisan migrate --force --path=database/migrations --step || { echo "Migration encountered errors but continuing..."; true; }
    php artisan db:seed
    touch "$FIRST_RUN_FILE"

    echo "Selesai"

else
    echo "Bukan run pertama kali"
    ls /var/www
fi

echo "Service berjalan"
wait %1
trap - ERR
