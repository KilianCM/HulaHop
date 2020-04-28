FROM php:7.4-fpm

COPY ./ /app
WORKDIR /app

ADD https://getcomposer.org/composer-stable.phar /usr/bin/composer

RUN chmod a+x /usr/bin/composer

RUN apt-get update && \
    apt-get install -y git libcurl3-dev libzip-dev nodejs npm

RUN docker-php-ext-install pdo pdo_mysql curl zip

RUN composer install