FROM php:7.4-fpm-alpine

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

RUN apk add --update --no-cache --virtual .ext-deps \
        autoconf  \
        g++ \
        make
RUN \
    apk add --no-cache --virtual openssl-dev pcre-dev
RUN \
    pecl install redis xdebug && \
    pecl clear-cache && \
    docker-php-ext-enable redis xdebug
