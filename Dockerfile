FROM node:lts AS build-node-stage

COPY ./ /app
WORKDIR /app

RUN npm install \
    && npm run build


FROM php:7.4-fpm

ADD https://getcomposer.org/composer-stable.phar /usr/bin/composer

RUN chmod a+x /usr/bin/composer

RUN apt-get update && \
    apt-get install -y git libcurl3-dev libzip-dev

RUN docker-php-ext-install pdo pdo_mysql curl zip

COPY --from=build-node-stage /app /app
WORKDIR /app

RUN composer install -o --no-scripts