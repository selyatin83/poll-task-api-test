FROM php:8.2.1-fpm

RUN apt-get update
RUN apt-get install -y --no-install-recommends \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libicu-dev \
        libxml2-dev \
        libzip-dev \
        libonig-dev \
        unzip \
        libpq-dev

RUN docker-php-ext-install pdo_pgsql sockets
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-configure zip \
    && docker-php-ext-install intl mbstring pdo_mysql exif gd pcntl soap bcmath zip

COPY ./php.ini /usr/local/etc/php/
COPY ./www.conf /usr/local/etc/php/

RUN apt-get purge -y g++ \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/*

RUN usermod -u 1000 www-data

RUN curl https://getcomposer.org/composer.phar > /usr/local/bin/composer && chmod a+x /usr/local/bin/composer

EXPOSE 9000
WORKDIR "/app"
CMD ["php-fpm"]
