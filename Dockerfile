# Dockerfile
FROM php:8.2-fpm

USER root

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    unzip \
    libmagickwand-dev \
    imagemagick \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# add user for laravel application
RUN groupadd -g 1000 www || echo "Group 'www' already exists"
RUN id -u www || useradd -u 1000 -ms /bin/bash -g www www

# copy the existing directory to /var/www
COPY . /var/www

# copy application directory permissions
COPY --chown=www:www . /var/www

# change current user to www
USER www

# expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
