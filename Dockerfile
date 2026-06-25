FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libmariadb-dev \
    zip \
    unzip \
    git \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mysqli \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-interaction --optimize-autoloader --no-dev

RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache && \
    chmod -R 775 storage bootstrap/cache

RUN npm install && npm run build

RUN if [ ! -f .env ]; then cp .env.example .env; fi

RUN php artisan key:generate --force

EXPOSE 8000

CMD ["sh", "-c", "php artisan config:clear && php artisan migrate --force && php artisan db:seed --force && echo 'Starting server on port '${PORT:-8000} && php -S 0.0.0.0:${PORT:-8000} -t public public/index.php"]