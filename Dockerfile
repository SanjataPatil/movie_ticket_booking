# Use official PHP with Apache
FROM php:8.1-apache

# Enable Apache rewrite module
RUN a2enmod rewrite

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy your PHP app into the container
COPY movie_booking /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 (Apache default)
EXPOSE 80
