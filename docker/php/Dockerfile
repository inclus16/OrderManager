FROM php:fpm-alpine


RUN apk --update add --no-cache \
         php7-pdo \
         php7-pdo_pgsql \
         php7-pgsql \
         php7-phar \
         php7-zip \
         php7-zlib



COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

CMD ["php-fpm"]

EXPOSE 9000