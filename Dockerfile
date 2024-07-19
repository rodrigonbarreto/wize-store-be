FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install zip pdo pdo_mysql

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# define o directory
WORKDIR /var/www/html

# copy the composer files
COPY composer.json composer.lock ./

# install the composer dependencies
RUN composer install --no-scripts --no-autoloader

# copy the rest of the files
COPY . .

# generate the autoload files
RUN composer dump-autoload

# Permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Export the port
EXPOSE 8000

# Run the server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
