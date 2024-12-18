# Use a multi-stage build
FROM php:8.1-fpm AS builder

# Set non-interactive frontend for apt-get
ENV DEBIAN_FRONTEND=noninteractive

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

# PHP extensions and Composer
RUN docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd zip
RUN pecl install redis memcached && docker-php-ext-enable redis memcached
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set up the working directory
WORKDIR /var/www
COPY . .
# Generate optimized autoloader
RUN composer dump-autoload --optimize

# Nginx configuration
RUN rm -f /etc/nginx/sites-enabled/default
COPY nginx.conf /etc/nginx/sites-available/default
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/

# Permissions
RUN chown -R www-data:www-data /var/www
RUN chmod -R 775 /var/www

# Final stage
FROM php:8.1-fpm

# Set non-interactive frontend for apt-get
ENV DEBIAN_FRONTEND=noninteractive

COPY custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini

# Copy only necessary files from builder
COPY --from=builder /var/www /var/www
COPY --from=builder /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d
COPY --from=builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=builder /etc/nginx /etc/nginx

# Install only runtime dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    nginx \
    libpq5 \
    libmemcached11 \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

EXPOSE 80
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
