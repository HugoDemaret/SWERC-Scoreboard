FROM php:apache
RUN apt-get update && apt-get upgrade -y
RUN a2enmod rewrite
RUN service apache2 restart
EXPOSE 8080