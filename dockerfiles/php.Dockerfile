FROM php:8.2-fpm

WORKDIR /var/www/laravel

RUN apt-get update && apt-get install -y \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
        libwebp-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp

RUN docker-php-ext-install -j$(nproc) gd pdo pdo_mysql exif