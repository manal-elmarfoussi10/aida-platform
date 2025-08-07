# -----------------------
# 1. Use PHP image
FROM php:8.2-fpm

# 2. Install system dependencies
# 2. Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    nano \
    libpq-dev \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# 3. Install Composer
COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

# 4. Set working directory
WORKDIR /var/www

# 5. Copy project files
COPY . .

# 6. Install PHP and NPM dependencies
# Instead of chaining them, separate like this:
    RUN composer install --no-dev --optimize-autoloader
    RUN npm install
    RUN npm run build

# 7. Set permissions
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# 8. Expose Laravel dev server
EXPOSE 8000

# 9. Run Laravel dev server
CMD php artisan serve --host=0.0.0.0 --port=8000