FROM php:8.3-apache

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

RUN a2enmod rewrite
RUN a2dismod mpm_event && a2enmod mpm_prefork

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

RUN composer install --no-interaction --optimize-autoloader --no-dev

RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache && \
    chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

RUN npm install && npm run build

RUN if [ ! -f .env ]; then cp .env.example .env; fi

RUN chmod +x docker/start.sh

EXPOSE 80

CMD ["sh", "docker/start.sh"]