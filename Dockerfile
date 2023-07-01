FROM php:7.4-apache

RUN apt-get update && \
    apt-get install -y git zip unzip libzip-dev libpng-dev libjpeg-dev && \
    docker-php-ext-install pdo_mysql zip gd && \
    a2enmod rewrite

COPY . /var/www/html/

WORKDIR /var/www/html/

COPY composer.json composer.lock /var/www/html/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --no-dev

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage/logs

RUN cd /var/www/html/ && \
    php artisan config:cache && \
    php artisan cache:clear && \
    php artisan view:clear && \
    php artisan route:clear

COPY myapp.conf /etc/apache2/sites-available/

RUN a2ensite myapp.conf

EXPOSE 80

CMD ["apache2ctl", "-DFOREGROUND"]
