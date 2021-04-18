FROM elliotjreed/symfony-php-fpm-docker:php8

LABEL Description="Florii API PHP Docker image." Vendor="Bunches" Version="2.0"

ENV TZ='Europe/London'

WORKDIR /var/www/html

USER root

COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/99-overrides.ini
COPY ./docker/php/fpm.conf /usr/local/etc/php-fpm.conf

RUN chown -R www-data:www-data /var/www/html && \
    touch /usr/local/var/log/php-fpm.log && \
    chmod 777 /usr/local/var/log/php-fpm.log

USER www-data

RUN mkdir -p /var/www/html/var/cache/prod && \
    mkdir -p /var/www/html/var/log && \
    chmod -R 777 /var/www/html/var

COPY --chown=www-data:www-data ./composer.json /var/www/html/composer.json
COPY --chown=www-data:www-data ./config /var/www/html/config
COPY --chown=www-data:www-data ./public /var/www/html/public
COPY --chown=www-data:www-data ./src /var/www/html/src
COPY --chown=www-data:www-data ./vendor /var/www/html/vendor
COPY --chown=www-data:www-data ./bin/console /var/www/html/bin/console

RUN chmod +x /var/www/html/bin/console
