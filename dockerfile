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

# 8. Create nginx configuration
RUN echo 'server {\n\
    listen 8080;\n\
    server_name _;\n\
    root /var/www/html/public;\n\
    index index.php;\n\
    client_max_body_size 100M;\n\
    location / {\n\
        try_files $uri $uri/ /index.php?$query_string;\n\
    }\n\
    location ~ \.php$ {\n\
        fastcgi_pass 127.0.0.1:9000;\n\
        fastcgi_index index.php;\n\
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;\n\
        include fastcgi_params;\n\
    }\n\
}' > /etc/nginx/sites-available/default

# 9. Create supervisor configuration
RUN echo '[supervisord]\n\
nodaemon=true\n\
user=root\n\
\n\
[program:php-fpm]\n\
command=/usr/local/sbin/php-fpm\n\
autostart=true\n\
autorestart=true\n\
stderr_logfile=/var/log/php-fpm.err.log\n\
stdout_logfile=/var/log/php-fpm.out.log\n\
\n\
[program:nginx]\n\
command=/usr/sbin/nginx -g "daemon off;"\n\
autostart=true\n\
autorestart=true\n\
stderr_logfile=/var/log/nginx.err.log\n\
stdout_logfile=/var/log/nginx.out.log' > /etc/supervisor/conf.d/supervisord.conf

# 10. Create and configure entrypoint script
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

# 11. Fix permissions
RUN chown -R root:root /var/www/html/storage /var/www/html/bootstrap/cache

# 12. Expose Port
EXPOSE 8080

# 12. Start Command
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]