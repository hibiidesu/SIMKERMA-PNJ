FROM php:8.1-fpm
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    libmemcached-dev \
    zlib1g-dev \
    libzip-dev
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd
RUN pecl install redis memcached && docker-php-ext-enable redis memcached
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
COPY . /var/www
RUN composer install --ignore-platform-reqs
RUN chown -R www-data:www-data /var/www
EXPOSE 9000
RUN chmod +x /var/www/entrypoint.sh
CMD ["/var/www/entrypoint.sh"]

