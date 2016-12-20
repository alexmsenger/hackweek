FROM php:5.6-apache
RUN apt-get update && apt-get install -y \
  curl \
  libmcrypt-dev \
  && docker-php-ext-install mysqli pdo pdo_mysql mcrypt

RUN a2enmod rewrite

COPY config/php.ini /usr/local/etc/php/php.ini
