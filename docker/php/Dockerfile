FROM php:7.4-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /tmp

RUN echo ">>> Install composer" \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY composer.json /tmp/composer.json
COPY composer.lock /tmp/composer.lock

RUN echo ">>> Composer install" \
    && composer install

COPY ./vendor/ /var/www/vendor/

CMD ["php-fpm"]

