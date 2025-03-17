FROM php:8.3.8-fpm-bullseye

ARG TIMEZONE

ARG UID
ARG GID
ARG LOCAL_USER

ENV UID=${UID}
ENV GID=${GID}
ENV LOCAL_USER=${LOCAL_USER}

COPY .docker/php-fpm/php.ini /usr/local/etc/php/conf.d/docker-php-config.ini
COPY .docker/php-fpm/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    libcurl4-openssl-dev  \
    pkg-config \
    libssl-dev \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN docker-php-ext-configure gd --with-jpeg --with-freetype

RUN docker-php-ext-install pdo pdo_mysql zip xsl gd intl opcache exif mbstring

RUN pecl install xdebug-3.3.0
RUN docker-php-ext-enable xdebug

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# MacOS staff group's gid is 20, so is the dialout group in alpine linux. We're not using it, let's just remove it.
RUN delgroup dialout

RUN addgroup --gid ${GID} ${LOCAL_USER}
RUN adduser --gid ${GID} --disabled-password --shell /bin/sh -u ${UID} ${LOCAL_USER}

RUN sed -i "s/user = www-data/user = ${LOCAL_USER}/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = ${LOCAL_USER}/g" /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www