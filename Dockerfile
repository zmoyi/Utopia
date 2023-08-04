FROM php:8.1-fpm

ARG APP_PATH=/www/app/
RUN apt-get update && apt-get install -y \
    libfreetype-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN pecl install redis-5.3.7 \
    && pecl install xdebug-3.2.1 \
    && docker-php-ext-enable redis xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR $APP_PATH

ADD . $APP_PATH


