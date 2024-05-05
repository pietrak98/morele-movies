FROM php:8.3-fpm-alpine

RUN apk update

RUN apk add \
    bash \
    git \
    build-base \
    gcc \
    autoconf \
    libmcrypt-dev \
    libzip-dev  \
    zip \
    g++ \
    make \
    openssl-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libpng \
    libjpeg-turbo \
    libjpeg-turbo-dev \
    libpq-dev \
    icu-dev \
    oniguruma-dev \
    jpegoptim  \
    optipng  \
    pngquant  \
    gifsicle \
    linux-headers \
    gpgme-dev \
    libxml2-dev \
    gnupg \
    libc-dev\
    acl

RUN docker-php-ext-install bcmath
RUN docker-php-ext-install exif
RUN docker-php-ext-configure gd && docker-php-ext-install -j$(nproc) gd
RUN docker-php-ext-install intl
RUN docker-php-ext-install mbstring
RUN docker-php-ext-configure pcntl --enable-pcntl && docker-php-ext-install pcntl
RUN docker-php-ext-install pdo
RUN docker-php-ext-install sockets
RUN docker-php-ext-install zip

RUN docker-php-source extract

RUN docker-php-source delete \
    && rm -rf \
            /tmp/* \
            /usr/includes/* \
            /usr/share/man/* \
            /usr/src/* \
            /var/cache/apk/* \
            /var/tmp/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer; exit 0

WORKDIR /var/www/html

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash
RUN apk update
RUN apk add symfony-cli

EXPOSE 9000
CMD ["php-fpm"]
