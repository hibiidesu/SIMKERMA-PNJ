#!/bin/bash
php-fpm &
sleep 10

# MIGRATE & SEEDING KALO ENV APP LOCAL
if [ "$APP_ENV" = "local" ]; then
    echo "Running migrations and seeding..."
    php artisan migrate --force
    php artisan db:seed --force
else
    echo "Skipping migrations and seeding (APP_ENV is not set to local)"
fi

wait
