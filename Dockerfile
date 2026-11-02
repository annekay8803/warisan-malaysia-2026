FROM php:8.3-cli

RUN apt-get update \
 && apt-get install -y --no-install-recommends git unzip libzip-dev libsqlite3-dev \
 && docker-php-ext-install pdo_sqlite zip \
 && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction \
 && touch database/database.sqlite \
 && chmod -R 775 storage bootstrap/cache database

ENV DB_CONNECTION=sqlite
ENV DB_DATABASE=/app/database/database.sqlite
ENV APP_ENV=production
ENV APP_DEBUG=false

CMD php artisan migrate --force --seed && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}