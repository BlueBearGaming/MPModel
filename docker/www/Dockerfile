FROM bluebeargaming/ubuntu-server

USER root

RUN add-apt-repository ppa:ondrej/php
RUN apt-get update

# Custom php extensions
RUN apt-get install -y \
    mariadb-client \
    nginx \
    php7.2-fpm \
    php7.2-cli \
    php7.2-intl \
    php7.2-xml \
    php7.2-zip \
    php7.2-mbstring \
    php7.2-gd \
    php7.2-apcu \
    php7.2-mysql \
    php7.2-curl

# Fix fastcgi params in nginx
COPY nginx/snippets/fastcgi-php.conf /etc/nginx/snippets/fastcgi-php.conf

# Enabling our custom config
COPY php/mods-available/symfony.ini /etc/php/7.2/mods-available/symfony.ini
RUN phpenmod symfony

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# DEV ONLY !!!
RUN apt-get install -y php-xdebug
COPY php/mods-available/xdebug.ini /etc/php/7.2/mods-available/xdebug.ini

COPY start.sh /var/www/start.sh

# Rollback default shell
USER www-data

ENTRYPOINT ["/var/www/start.sh"]
