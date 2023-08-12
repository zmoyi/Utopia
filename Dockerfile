FROM php:8.2-fpm
ARG APP_PATH=/www/app/
# 添加工作目录
WORKDIR ${APP_PATH}
# add composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN apt-get update && apt-get install -y curl \
    unzip \
    libfreetype-dev \
    libjpeg62-turbo-dev \
    libpng-dev
RUN pecl install redis-5.3.7 \
    && docker-php-ext-install pdo_mysql exif bcmath gd gettext iconv mysqli opcache sockets

ADD https://app.fresns.cn/latest.zip ${APP_PATH}
RUN <<EOT bash
unzip latest.zip
folder_name=$(unzip -l latest.zip | awk '{print $NF}' | grep -m 1 'fresns-v[0-9]\+\.[0-9]\+\.[0-9]\+')
mv "$folder_name"/* .
rmdir "$folder_name"
EOT
