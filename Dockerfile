FROM php:8.3-apache

# 1. Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git

# 2. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Configure Apache Document Root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 4. Enable Apache mod_rewrite
RUN a2enmod rewrite

# 5. Set working directory and copy files
WORKDIR /var/www/html
COPY . /var/www/html

# 6. Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader

# 7. Final Command (must be last)
# This swaps the port dynamically for Railway and starts Apache
CMD sed -i "s/Listen 80/Listen ${PORT:-10000}/" /etc/apache2/ports.conf && \
    sed -i "s/:80/:${PORT:-10000}/" /etc/apache2/sites-available/000-default.conf && \
    apache2-foreground