FROM php:8.0-apache
MAINTAINER Lucas Falcão <lughfalcao@gmail.com>
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update && apt-get upgrade -y
RUN a2enmod rewrite
ADD . /var/www/html