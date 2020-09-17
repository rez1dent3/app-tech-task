FROM library/php:7.4-fpm

RUN apt-get update && apt-get install -y apt-utils git libzip-dev \
    && docker-php-ext-install -j$(nproc) pdo_mysql pcntl zip

ENV COMPOSER_ALLOW_SUPERUSER 1
COPY --from=library/composer:1 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/app
