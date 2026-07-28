FROM php:8.1-fpm-alpine

# Install system dependencies & PHP extensions
RUN apk add --no-linux-headers --no-cache \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    oniguruma-dev

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd opcache

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
