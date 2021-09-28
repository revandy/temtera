FROM php:7.3-fpm

RUN apt-get update -y && apt-get install -y libmcrypt-dev openssl
RUN apt-get install -y curl && apt-get install -y zip
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql
WORKDIR /app
COPY . /app
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install