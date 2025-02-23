# Use the official PHP image
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install zip pdo pdo_mysql pdo_pgsql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /app

# Copy application files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Cache configuration
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Expose port
EXPOSE 10000

# Start the application
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]