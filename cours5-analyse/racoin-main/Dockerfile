FROM php:7.4

RUN apt update && apt install -y \
    git \
    zip \
    unzip \
    libxml2-dev \
    default-mysql-client

RUN docker-php-ext-install pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html