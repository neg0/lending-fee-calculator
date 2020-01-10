FROM php:7.3-cli

RUN apt-get update -y && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libc6 \
    libgcc1 \
    libbz2-dev \
    && docker-php-ext-install bz2 \
    && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version

RUN pecl install xdebug-2.8.1 \
    && echo "zend_extension=xdebug.so" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN mkdir -p /var/apps/lendable

VOLUME /var/apps/lendable

WORKDIR /var/apps/lendable