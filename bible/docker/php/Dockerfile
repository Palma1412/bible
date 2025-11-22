FROM php:8.2-fpm

RUN apt-get update

RUN apt-get install -y \
    libpq-dev \
     git \
     unzip \
     zip \
    && docker-php-ext-install pdo pdo_pgsql sockets

WORKDIR /var/www

COPY ./project/ .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-dev --optimize-autoloader

ARG REMOTE_HOST="host.docker.internal"
ARG REMOTE_PORT=9003

ENV CLIENT_HOST=$REMOTE_HOST
ENV CLIENT_PORT=$REMOTE_PORT

CMD php artisan serve --host=0.0.0.0 --port=8000






