FROM php:8-fpm

WORKDIR /var/www

ENV MAIL_HOST smtp.mailtrap.io
ENV MAIL_USERNAME 1ce900dac80e6b
ENV MAIL_PASSWORD 988247eb1a3b05
ENV MAIL_FROM_ADDRESS etech@gmail.com
#RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
#RUN docker-php-ext-install gd

RUN apt update && apt install -y \
        build-essential \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        locales \
        zip \
        jpegoptim optipng pngquant gifsicle \
        vim \
        libzip-dev \
        unzip \
        git \
        libonig-dev \
        curl &&\
    apt clean && rm -rf /var/lib/apt/lists/* &&  \
    docker-php-ext-install pdo_mysql mbstring zip exif pcntl && \
    groupadd -g 1000 www && \
    useradd -u 1000 -ms /bin/bash -g www www


COPY --from=composer --chown=www:www /usr/bin/composer /usr/bin/composer
COPY . .
COPY .env.example .env

RUN chown -R www:www /var/www
USER www

RUN echo MAIL_HOST=${MAIL_HOST} >> .env && \
      echo MAIL_USERNAME=${DB_PASSWORD_PRODUCT} >> .env && \
      echo MAIL_PASSWORD=${DB_PASSWORD_PRODUCT} >> .env && \
      echo MAIL_FROM_ADDRESS=${DB_PASSWORD_PRODUCT} >> .env && \
      composer install -q && \
      chmod +x ./docker/wait-for-it.sh

EXPOSE 9000
#CMD sh ./docker/wait-for-it.sh db:3306 -- sh ./docker/start.sh
CMD ["sh","./docker/start.sh"]