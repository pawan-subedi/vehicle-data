FROM php:7.4-fpm-alpine

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

RUN apk add --update --no-cache --virtual .ext-deps \
        autoconf  \
        g++ \
        make
RUN \
    apk add --no-cache --virtual openssl-dev pcre-dev
RUN \
    pecl install redis && \
    pecl clear-cache && \
    pecl install memcached && \
    docker-php-ext-enable redis &&\
    docker-enable-ext php-memcached