FROM php:8.2-apache

# Set locale and timezone support
RUN apt-get update && apt-get install -y locales tzdata && \
    echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && locale-gen

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    libwebp-dev \
    libavif-dev \
    zip \
    unzip \
    git \
    curl \
    default-mysql-client \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp --with-avif \
    && docker-php-ext-install -j$(nproc) \
    gd \
    pdo_mysql \
    mysqli \
    zip \
    intl \
    bcmath \
    exif \
    gettext \
    opcache \
    mbstring

# Enable Apache modules
RUN a2enmod rewrite headers expires

# PHP configuration for performance
RUN echo "upload_max_filesize = 64M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 64M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 512M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_input_time = 300" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_input_vars = 5000" >> /usr/local/etc/php/conf.d/uploads.ini

# OPcache configuration for production performance
RUN echo "opcache.enable=1" > /usr/local/etc/php/conf.d/opcache-recommended.ini \
    && echo "opcache.memory_consumption=512" >> /usr/local/etc/php/conf.d/opcache-recommended.ini \
    && echo "opcache.max_accelerated_files=40000" >> /usr/local/etc/php/conf.d/opcache-recommended.ini \
    && echo "opcache.revalidate_freq=60" >> /usr/local/etc/php/conf.d/opcache-recommended.ini \
    && echo "opcache.fast_shutdown=1" >> /usr/local/etc/php/conf.d/opcache-recommended.ini \
    && echo "opcache.validate_timestamps=1" >> /usr/local/etc/php/conf.d/opcache-recommended.ini \
    && echo "opcache.max_file_size=0" >> /usr/local/etc/php/conf.d/opcache-recommended.ini

# Security hardening (WordPress-compatible)
RUN echo "expose_php = Off" > /usr/local/etc/php/conf.d/security.ini

# Allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Set DocumentRoot & timezone
ENV TZ=UTC
WORKDIR /var/www/html
