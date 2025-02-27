FROM php:7.2-apache

RUN apt-get update

WORKDIR /var/www/html/
COPY ./src .

RUN chown -R root:www-data /var/www/html
RUN chmod 750 /var/www/html
RUN chmod +t -R /var/www/html/