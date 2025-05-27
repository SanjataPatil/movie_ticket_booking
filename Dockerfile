# Use the official PHP-Apache image
FROM php:8.1-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy all project files to the container's web root
COPY . /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html
