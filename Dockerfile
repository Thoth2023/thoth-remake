FROM php:8.1-fpm

# set your user name, ex: user=bernardo
ARG user=thoth
ARG uid=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nano \
    libwebp-dev \
    -y mariadb-client

# Install Node.js and npm
RUN apt-get install -y nodejs npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets
#RUN docker-php-ext-install mysqli pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd intl zip opcache

RUN apt-get update && apt-get install -y libzip-dev zip && docker-php-ext-install zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Install redis
RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

COPY ./xdebug.ini "${PHP_INI_DIR}/conf.d"

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN echo "file_uploads = On\n" \
         "memory_limit = 512M\n" \
         "upload_max_filesize = 256M\n" \
         "post_max_size = 256M\n" \
         "max_execution_time = 60\n" \
         > /usr/local/etc/php/conf.d/docker-php-uploads.ini

# Set working directory
WORKDIR /var/www

# Install Node.js and npm
USER root
RUN apt-get update && apt-get install -y \
    nodejs \
    npm

USER $user

# Copy custom configurations PHP
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini



## Use a imagem base desejada, por exemplo:
    # FROM php:7.4

    ## Copie o Makefile para o diretório /app do contêiner
    # COPY Makefile /app/Makefile

    ## Defina o diretório de trabalho como /app
    #WORKDIR /app

