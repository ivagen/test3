FROM ubuntu:16.04

MAINTAINER Evgeniy Ivashko <ivashko_e@ukr.net>

# Environment
ARG UID=1000
ENV UID $UID

RUN apt-get update \
    && apt-get install -y software-properties-common python-software-properties language-pack-en-base

RUN LC_ALL=en_US.UTF-8 add-apt-repository -y -u ppa:ondrej/php

# PHP
RUN apt-get update \
 && apt-get install -y \
  php7.1 \
  php7.1-fpm \
  php-dev \
  php-mysql \
  php7.1-pdo \
  php-mbstring \
  php-xml \
  php-bcmath \
  php-gd \
  php-intl \
  php-curl \
  php-redis \
  php-pear \
  php-xdebug

# Other programms
RUN apt-get install -y \
  sudo nginx-full curl unzip nano git git-core wget cron

# PHPUnit
RUN wget https://phar.phpunit.de/phpunit.phar
RUN chmod +x phpunit.phar
RUN mv phpunit.phar /usr/local/bin/phpunit

# ImageMagick
RUN apt-get install -y \
  libmagickwand-dev imagemagick

RUN pecl install imagick
RUN pecl install apcu

# Install npm, bower and gulp
RUN apt-get install -y python-software-properties
RUN curl -sL https://deb.nodesource.com/setup_7.x | sudo -E bash -
RUN apt-get install -y nodejs
RUN npm install -g bower gulp gulp-concat

# Clear
RUN apt-get remove --purge -y $BUILD_PACKAGES \
 && rm -rf /var/lib/apt/lists/*

# Forego
RUN curl -O https://bin.equinox.io/c/ekMN3bCZFUn/forego-stable-linux-amd64.tgz \
 && tar -xzf forego-stable-linux-amd64.tgz -C /usr/bin \
 && rm forego-stable-linux-amd64.tgz \
 && mkdir -p /run/php

# Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Configs
COPY nginx.conf /etc/nginx/sites-available/default
COPY Procfile /

RUN echo 'date.timezone = "Europe/Kiev"' >> /etc/php/7.1/fpm/php.ini \
 && echo 'date.timezone = "Europe/Kiev"' >> /etc/php/7.1/cli/php.ini \
 && echo 'extension = imagick.so' > /etc/php/7.1/cli/conf.d/20-imagick.ini \
 && echo 'extension = imagick.so' > /etc/php/7.1/fpm/conf.d/20-imagick.ini \
 && echo 'extension=apcu.so' > /etc/php/7.1/cli/conf.d/20-apcu.ini \
 && echo 'extension=apcu.so' > /etc/php/7.1/fpm/conf.d/20-apcu.ini \
 && echo 'cgi.fix_pathinfo=0' >> /etc/php/7.1/fpm/php.ini \
 && echo 'xdebug.remote_enable=1' >> /etc/php/7.1/fpm/php.ini

ADD ./crontab /etc/cron.d/test
RUN chmod 0644 /etc/cron.d/test
RUN touch /var/log/cron.log
RUN crontab /etc/cron.d/test

# User and user mode
RUN usermod -u ${UID} www-data
RUN echo "www-data:www-data" | chpasswd && adduser www-data sudo
RUN sed -i.bkp -e \
  's/%sudo\s\+ALL=(ALL\(:ALL\)\?)\s\+ALL/%sudo ALL=NOPASSWD:ALL/g' \
  /etc/sudoers

USER www-data

ENV TERM xterm

EXPOSE 80

WORKDIR "/var/www"

CMD sudo forego start -f /Procfile
