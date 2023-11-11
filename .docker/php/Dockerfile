FROM php:8.1.6-fpm as base

ARG user=app

RUN apt-get update && apt-get install -y --force-yes --no-install-recommends \
    cron \
    git \
    libfreetype6-dev \
    libgmp-dev \
    libjpeg-dev \
    libmagickwand-dev \
    libmemcached-dev \
    libpng-dev \
    libpq-dev \
    libreadline-dev \
    libssl-dev \
    libxml2-dev \
    libz-dev \
    libzip-dev \
    libzip-dev \
    mariadb-client \
    nano \
    nodejs \
    npm \
    openssh-server \
    unzip \
    ghostscript

# Install soap extention
RUN docker-php-ext-install soap

# Install for image manipulation
RUN docker-php-ext-install exif

# Install the PHP pcntl extention
RUN docker-php-ext-install pcntl

# Install the PHP zip extention
RUN docker-php-ext-install zip

# Install the PHP pdo_mysql extention
RUN docker-php-ext-install pdo_mysql

# Install the PHP pdo_pgsql extention
RUN docker-php-ext-install pdo_pgsql

# Install the PHP bcmath extension
RUN docker-php-ext-install bcmath

# Install the PHP intl extention
RUN docker-php-ext-install intl

# Install the PHP gmp extention
RUN docker-php-ext-install gmp

#####################################
# PHPRedis:
#####################################
# RUN pecl install redis && docker-php-ext-enable redis

#####################################
# Imagick:
#####################################

RUN pecl install imagick && \
    docker-php-ext-enable imagick && \
    sed -i 's/domain="coder" rights="none" pattern="PDF"/domain="coder" rights="read|write" pattern="PDF"/g' /etc/ImageMagick-6/policy.xml

#####################################
# GD:
#####################################

# Install the PHP gd library
RUN docker-php-ext-install gd && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

#####################################
# xDebug:
#####################################

# Install the xdebug extension
RUN pecl install xdebug

#####################################
# PHP Memcached:
#####################################

# Install the php memcached extension
RUN pecl install memcached && docker-php-ext-enable memcached

#####################################
# Composer:
#####################################

# Install composer and add its bin to the PATH.
RUN curl -s http://getcomposer.org/installer | php && \
    echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc && \
    mv composer.phar /usr/local/bin/composer && \
    . ~/.bashrc && \
    rm -rf /var/www/html

#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u 1000 -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user && \
    chown -R $user:$user /var/www
RUN mkdir -p /home/$user/.ssh && \
    chown -R $user:$user /home/$user/.ssh && \
    echo "Host github-oauth.github.com\n\tStrictHostKeyChecking no\n" >> /home/$user/.ssh/config

RUN ln -s public html

WORKDIR /var/www

USER $user

EXPOSE 8000

FROM base as install
CMD [ "composer", "install" ]

FROM base as php-clean-installation

ENTRYPOINT [ "php", "-S", "0.0.0.0:8000" ]

FROM base as local

ENTRYPOINT [ "php", "artisan", "serve" ]
CMD [ "--host=0.0.0.0" ]