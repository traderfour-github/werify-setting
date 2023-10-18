FROM php:8.1.0-apache

COPY . /var/www/html

# Update apt
RUN apt-get update
RUN apt-get install libcurl4 libcurl4-openssl-dev libzip-dev libpq-dev libpng-dev libfreetype6-dev libjpeg62-turbo-dev libxml2-dev -y 

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Extensions
RUN docker-php-ext-install pcntl opcache soap zip pdo_pgsql pdo_mysql
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install gd
RUN pecl install -o -f redis &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis
RUN pecl install mongodb

COPY ./docker/php.ini /usr/local/etc/php/conf.d/

# Apache
RUN a2enmod rewrite
COPY ./docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Remove dev composer packages
RUN composer update --optimize-autoloader --no-dev --ignore-platform-reqs
RUN composer install --optimize-autoloader --no-dev --ignore-platform-reqs

RUN composer dump-autoload

RUN chown -R www-data:www-data storage

EXPOSE 80
