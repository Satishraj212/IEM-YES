# build v4
FROM php:8.4-cli-alpine

RUN apk add --no-cache \
    git curl zip unzip \
    libpng-dev oniguruma-dev libxml2-dev \
    sqlite-libs sqlite-dev \
    nodejs npm

RUN docker-php-ext-install pdo pdo_sqlite mbstring exif pcntl bcmath gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Force cache invalidation so new files (server.php) are always copied
ARG CACHEBUST=4
COPY . .

RUN composer install --optimize-autoloader --no-dev --no-interaction

RUN npm install && npm run build

RUN mkdir -p storage/logs \
             storage/framework/cache \
             storage/framework/sessions \
             storage/framework/views \
    && touch database/database.sqlite \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD php artisan config:cache || true \
    && php artisan route:cache || true \
    && php artisan view:cache || true \
    && php -S 0.0.0.0:${PORT:-8000} server.php
