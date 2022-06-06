FROM php:8.0.11-apache

RUN apt-get update && apt-get install -y autoconf pkg-config apt-utils git vim openssl zip libssl-dev unzip\
    && docker-php-ext-install pdo pdo_mysql && apt-get install vim && apt-get install nano

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY ./etc/apache/default.conf /etc/apache2/sites-available/000-default.conf

RUN pecl install mongodb && docker-php-ext-enable mongodb

WORKDIR /var/www/html

RUN mkdir -p /var/www/html/storage/logs\
    && chmod -R 777 /var/www/html/storage/logs\
    && chown -R www-data:www-data /var/www/html/storage/logs

RUN a2enmod rewrite

RUN a2enmod ssl

EXPOSE 80