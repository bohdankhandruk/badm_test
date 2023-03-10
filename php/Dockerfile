FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    zlib1g-dev \
    libfreetype6-dev \
    wget \
    tar \
    imagemagick \
    zip \
    git

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN docker-php-ext-configure gd --with-jpeg --with-freetype

RUN docker-php-ext-install gd \
    opcache \
    pdo_mysql

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

RUN echo ' \n[xdebug] \n\
xdebug.client_host=172.17.0.1  \n\
xdebug.mode=develop,debug  \n\
xdebug.start_with_request=yes \n\
xdebug.idekey="VSCODE"  \n\
xdebug.log=/tmp/xdebug_remote.log  \n\
xdebug.client_port=9003  \n\
\n' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN composer global require "squizlabs/php_codesniffer=*"
RUN ln -s /root/.composer/vendor/bin/phpcs /usr/local/bin && \
    ln -s /root/.composer/vendor/bin/phpcbf /usr/local/bin

RUN composer global require drupal/coder
