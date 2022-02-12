FROM php:7.4-fpm
# Install "curl", "libmemcached-dev", "libpq-dev", "libjpeg-dev", "libpng12-dev", "libfreetype6-dev", "libssl-dev", "libmcrypt-dev",
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        git \
        wget \
        libmemcached-dev \
        libz-dev \
        libpq-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libssl-dev \
        cron \
        vim \
    && rm -rf /var/lib/apt/lists/*

# Install the PHP mysqli extention
RUN docker-php-ext-install mysqli

## Install the PHP mcrypt extention
#RUN docker-php-ext-install mcrypt

### Install the PHP pdo_sqlite extention
#RUN docker-php-ext-install pdo_sqlite

# Install the PHP pcntl extention
RUN docker-php-ext-install pcntl

# Install the PHP pcntl extention
RUN docker-php-ext-install bcmath

# Install the PHP pdo_mysql extention
RUN docker-php-ext-install pdo_mysql

# Install the PHP gd extention
RUN docker-php-ext-install gd

RUN docker-php-ext-install opcache

# Install the PHP soap extention
RUN apt-get update \
  && apt-get install -y --no-install-recommends -y \
    libxml2-dev \
#    php-soap \
  && apt-get clean -y \
  && rm -rf /var/lib/apt/lists/* \
  && docker-php-ext-install soap

# install mailhog
RUN apt-get update \
    && apt-get install --no-install-recommends --assume-yes --quiet ca-certificates curl git \
    && rm -rf /var/lib/apt/lists/*
RUN curl -Lsf 'https://storage.googleapis.com/golang/go1.8.3.linux-amd64.tar.gz' | tar -C '/usr/local' -xvzf -
ENV PATH /usr/local/go/bin:$PATH
RUN go get github.com/mailhog/mhsendmail \
    && cp /root/go/bin/mhsendmail /usr/bin/mhsendmail \
    && echo 'sendmail_path = /usr/bin/mhsendmail --smtp-addr mailhog:1025' > /usr/local/etc/php/php.ini

# install xdebug
RUN docker-php-source extract \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.idekey=ecom-multistore.local.env" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && rm -rf /tmp/*

# Install the PHP intl extention
RUN apt-get -y update \
    && apt-get install -y libicu-dev\
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

# Install the PHP amqp extention
RUN apt-get update \
    && apt-get install -y librabbitmq-dev libssh-dev \
    && pecl install amqp \
    && docker-php-ext-enable amqp

# Install the PHP imagick extention
RUN apt-get update \
    && apt-get install -y libmagickwand-dev --no-install-recommends \
    && pecl install imagick \
    && docker-php-ext-enable imagick

# Install the PHP mongodb extention
RUN apt-get update \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Install the PHP zip extention
RUN apt-get update \
    && apt-get install -y --no-install-recommends libzip-dev zip unzip \
    && docker-php-ext-install zip

## Install the PHP redis extention
#RUN curl -L -o /tmp/redis.tar.gz https://github.com/phpredis/phpredis/archive/5.1.1.tar.gz \
#    && tar xfz /tmp/redis.tar.gz \
#    && rm -r /tmp/redis.tar.gz \
#    && mkdir -p /usr/src/php/ext \
#    && mv phpredis-5.1.1 /usr/src/php/ext/redis \
#    && docker-php-ext-install redis

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set timezone
ENV TIMEZONE Africa/Casablanca
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
        && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
        && "date"

WORKDIR /var/www/
