#!/bin/bash
php-fpm &
echo "Nunggu koneksi DB"
sleep 30

FIRST_RUN_FILE="/var/www/html/.first_run_completed"

if [ ! -f "$FIRST_RUN_FILE" ]; then
    echo "First run! memulai seeding dan migrate"
    php artisan migrate --force || { echo "Migration gagal"; exit 1; }
    php artisan db:seed --force || { echo "Seeding gagal"; exit 1; }
    touch "$FIRST_RUN_FILE"

    echo "Selesai"
else
    echo "Bukan run pertama kali"
fi

echo "Service berjalan"
wait
trap - ERR
