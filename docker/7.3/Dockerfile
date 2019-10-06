FROM php:7.3

RUN apt-get update \
    && apt-get -y install libgmp-dev \ 
    && docker-php-ext-install gmp