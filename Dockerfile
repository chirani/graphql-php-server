FROM php:8.3-apache

# 1. Install system dependencies for Composer and Git
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# 2. Install Composer from the official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Configure Apache Document Root
# We hardcode /var/www/html/public to ensure Apache finds your index.php
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 4. Enable Apache mod_rewrite (essential for modern PHP routing)
RUN a2enmod rewrite

# 5. Set working directory and copy your project files
WORKDIR /var/www/html
COPY . /var/www/html

# 6. Install PHP dependencies
# This runs inside the container so you don't need 'vendor' in your Git repo
RUN composer install --no-interaction --optimize-autoloader

# 7. Final Command
# This dynamically sets the port (10000 for Render, or $PORT for Railway)
# then starts Apache in the foreground.
CMD sed -i "s/Listen 80/Listen ${PORT:-10000}/" /etc/apache2/ports.conf && \
    sed -i "s/:80/:${PORT:-10000}/" /etc/apache2/sites-available/000-default.conf && \
    apache2-foreground