FROM php:7.2-fpm

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get install -y git libicu-dev unzip \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) intl opcache \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN mkdir /var/www/.composer && chown www-data /var/www/.composer

COPY ./php-override.ini /usr/local/etc/php/conf.d/php-override.ini

# Fix permission issues for boot2docker
RUN usermod -u 1000 www-data