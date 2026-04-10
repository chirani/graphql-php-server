FROM php:8.3-apache

# 1. Install system dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# 2. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Configure Apache Document Root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 4. Enable Apache mod_rewrite
RUN a2enmod rewrite

# 5. Install PHP MySQL extensions (Compiling this takes time, do it before copying code)
RUN docker-php-ext-install pdo pdo_mysql

# 6. Set working directory and copy files
WORKDIR /var/www/html
COPY . /var/www/html

# 7. Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader

# 8. Final Command
# Note: I set the default back to 80 to match Apache's internal default, 
# but Render/Railway will override this via the $PORT variable.
CMD sed -i "s/Listen 80/Listen ${PORT:-80}/" /etc/apache2/ports.conf && \
    sed -i "s/:80/:${PORT:-80}/" /etc/apache2/sites-available/000-default.conf && \
    apache2-foreground