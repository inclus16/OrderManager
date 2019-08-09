FROM php:fpm-alpine


RUN apk --update add --no-cache \
        ca-certificates \
        postgresql-dev \
        curl \
        freetype \
        gettext \
        ghostscript-fonts \
        graphicsmagick \
        icu-libs \
        libedit \
        libgcc \
        libjpeg-turbo \
        libpng \
        libpq \
        libressl \
        libstdc++ \
        libxml2 \
        libzip \
        php7 \
        php7-ctype \
        php7-curl \
        php7-pecl-igbinary \
        php7-dom \
        php7-exif \
        php7-fileinfo \
        php7-fpm \
        php7-ftp \
        php7-gd \
        php7-gmagick \
        php7-iconv \
        php7-intl \
        php7-json \
        php7-mbstring \
        php7-mcrypt \
        php7-memcached \
        php7-opcache \
        php7-openssl \
        php7-pdo \
        php7-pdo_pgsql \
        php7-pgsql \
        php7-phar \
        php7-posix \
        php7-redis \
        php7-session \
        php7-sodium \
        php7-zip \
        php7-zlib \
        tar \
        xz


RUN docker-php-ext-install pdo pdo_pgsql

#need for laravel-doctrine/migrations
#RUN apk add git

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html