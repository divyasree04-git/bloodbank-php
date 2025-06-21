# Use an official PHP-FPM image as a base
FROM php:8.2-fpm-alpine

# Set working directory inside the container
WORKDIR /var/www/html

# Copy your application files into the container
COPY . .

# Install any PHP extensions if needed (e.g., MySQLi)
# If your app uses MySQLi, uncomment the following lines:
# RUN docker-php-ext-install mysqli pdo_mysql && docker-php-ext-enable mysqli

# Expose port 9000 for PHP-FPM (Render handles this internally)
EXPOSE 9000

# Command to run PHP-FPM when the container starts
CMD ["php-fpm"]