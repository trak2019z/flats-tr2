FROM php:7.2-fpm

#COPY ./php-fpm-pool.conf /usr/local/etc/php-fpm.conf

RUN apt-get update

RUN apt-get install -y zlib1g-dev libpq-dev git libicu-dev libxml2-dev unzip

RUN docker-php-ext-install intl
RUN docker-php-ext-configure intl
RUN docker-php-ext-install zip xml
RUN docker-php-ext-install pdo pdo_mysql mysqli


RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

WORKDIR /var/www/symfony

ADD ./docker-entrypoint.sh ./
RUN chmod 755 ./docker-entrypoint.sh

#ENTRYPOINT ["/var/www/symfony/docker-entrypoint.sh"]