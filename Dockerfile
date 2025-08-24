FROM php:8.2-fpm

# Install system dependencies + Imagick
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    git \
    zip \
    nodejs \
    npm \
    libzip-dev \
    libonig-dev \
    libmagickwand-dev --no-install-recommends \
    && rm -rf /var/lib/apt/lists/*

# Install Imagick
RUN pecl install imagick \
    && docker-php-ext-enable imagick

# Install PHP extensions (no GD here)
RUN docker-php-ext-install \
    pdo_mysql \
    zip

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php \
    -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www
