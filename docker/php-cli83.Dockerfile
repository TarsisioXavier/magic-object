FROM php:8.3-cli-alpine

RUN adduser app -shell /bin/sh --disabled-password --uid 1000

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions pcov xdebug

CMD [ "php", "-a" ]
