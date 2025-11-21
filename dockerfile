# Stage 1: Build the frontend assets
FROM node:18 as frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Stage 2: Build the application
FROM php:8.2-fpm

# 1. Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    supervisor \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl

# 2. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 3. Set working directory
WORKDIR /var/www/html

# 4. Copy application code
COPY . .

# 5. Copy frontend assets from Stage 1
COPY --from=frontend /app/public/build /var/www/html/public/build

# 6. Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# 7. Configure PHP-FPM to run as Root
RUN sed -i 's/user = www-data/user = root/g' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/group = www-data/group = root/g' /usr/local/etc/php-fpm.d/www.conf

# 8. Copy Configuration Files
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# 9. Create and configure entrypoint script
RUN echo '#!/bin/bash\n\
set -e\n\
\n\
# Run migrations\n\
php artisan migrate --force\n\
\n\
# Clear caches\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
\n\
# Start supervisor\n\
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf' > /usr/local/bin/entrypoint.sh && \
    chmod +x /usr/local/bin/entrypoint.sh

# 10. Fix permissions
RUN chown -R root:root /var/www/html/storage /var/www/html/bootstrap/cache

# 11. Expose Port
EXPOSE 8080

# 12. Start Command
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]