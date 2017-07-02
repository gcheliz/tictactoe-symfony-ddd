FROM php:7.1-fpm

RUN apt-get update

# Some basic extensions
RUN docker-php-ext-install -j$(nproc) json mbstring opcache pdo pdo_mysql mysqli

# Curl
RUN apt-get install -y libcurl4-openssl-dev git zip
RUN docker-php-ext-install -j$(nproc) curl

# GD
RUN apt-get install -y libpng-dev libjpeg-dev
RUN docker-php-ext-install -j$(nproc) gd

# Intl
RUN apt-get install -y libicu-dev
RUN docker-php-ext-install -j$(nproc) intl

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_CACHE_DIR /var/www/.composer

RUN usermod -u 1000 www-data

RUN echo 'alias sf="php app/console"' >> /etc/bash.bashrc

WORKDIR /var/www/symfony

EXPOSE 9000
