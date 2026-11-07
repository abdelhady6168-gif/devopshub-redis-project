FROM php:8.3-apache
RUN pecl install redis && docker-php-ext-enable redis
COPY index.php /var/www/html/
EXPOSE 80