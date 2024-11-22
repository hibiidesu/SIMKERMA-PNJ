FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    nginx \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    libmemcached-dev \
    zlib1g-dev \
    libzip-dev \
    netcat-openbsd \
    nano \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# PHP extensions and Composer
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip
RUN pecl install redis memcached && docker-php-ext-enable redis memcached
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . /var/www
COPY --chown=www-data:www-data . /var/www

# Nginx configuration
RUN rm /etc/nginx/sites-enabled/default
COPY nginx.conf /etc/nginx/sites-available/default
RUN ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/

# Permissions
RUN chown -R www-data:www-data /var/www
RUN chmod -R 775 /var/www

# Expose port and copy entrypoint
EXPOSE 80
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
