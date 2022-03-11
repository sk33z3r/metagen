FROM php:fpm

RUN apt-get update; \
    apt-get -y upgrade
RUN apt-get install -y libzip-dev zip
RUN docker-php-ext-install zip
