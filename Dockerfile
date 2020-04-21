FROM php:7.4-fpm

ADD https://getcomposer.org/composer-stable.phar /usr/bin/composer

RUN chmod a+x /usr/bin/composer

RUN apt-get update && \
    apt-get install -y git libcurl3-dev libzip-dev

RUN docker-php-ext-install pdo pdo_mysql curl zip
WORKDIR /hula-hop