FROM php:7.2-fpm

#COPY ./php-fpm-pool.conf /usr/local/etc/php-fpm.conf

RUN apt-get update

RUN apt-get install -y zlib1g-dev libpq-dev git libicu-dev libxml2-dev unzip

RUN docker-php-ext-install intl
RUN docker-php-ext-configure intl
RUN docker-php-ext-install zip xml
RUN docker-php-ext-install pdo pdo_mysql mysqli

#RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
#RUN apt-get install -y nodejs
#
#RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
#RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
#
#RUN apt update && apt install yarn
#
#RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

WORKDIR /var/www/symfony

#RUN composer install


#COPY docker-entrypoint.sh .
#RUN chmod +x ./docker-entrypoint.sh

#ENTRYPOINT ["/var/www/symfony/docker-entrypoint.sh"]