FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    libpq-dev \
    gnupg2 \
    && docker-php-ext-install pdo pdo_pgsql mbstring bcmath gd

# Install Node.js (LTS v18)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy app files
COPY . /var/www

COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

# Set correct permissions
RUN chown -R www-data:www-data /var/www && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Install Node dependencies and build assets
RUN npm install && npm run build

# Set safe git directory
RUN git config --global --add safe.directory /var/www

# Run Laravel optimization commands (optional)
RUN composer install \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

EXPOSE 9000

CMD ["php-fpm"]


