FROM library/php:7.4-fpm

RUN apt-get update && apt-get install -y libzip-dev \
    && docker-php-ext-install -j$(nproc) pdo_mysql zip

WORKDIR /var/www/tech

CMD ["php-fpm"]
