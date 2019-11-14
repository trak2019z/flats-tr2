FROM php:7.2-fpm

COPY ./php-fpm-pool.conf /usr/local/etc/php-fpm.conf

WORKDIR /home/wwwroot/
EXPOSE 9000
CMD ["php-fpm"]
