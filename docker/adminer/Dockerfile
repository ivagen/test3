FROM php:5.6-apache
RUN apt-get update && apt-get install -y libpq-dev --no-install-recommends && rm -r /var/lib/apt/lists/*
RUN docker-php-ext-install mysqli
RUN curl -L https://www.adminer.org/latest.php > /var/www/html/index.php
RUN chmod 755 /var/www/html && chmod 644 /var/www/html/index.php

RUN echo 'php_value upload_max_filesize 100M' > /var/www/html/.htaccess \
 && echo 'php_value post_max_size 100M' >> /var/www/html/.htaccess

RUN chmod 644 /var/www/html/.htaccess
VOLUME ["/var/www/html"]