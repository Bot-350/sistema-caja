FROM php:8.3-fpm

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    sqlite3 \
    libsqlite3-dev \
    nodejs \
    npm \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install \
    pdo \
    pdo_sqlite \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /app

# Copiar archivos
COPY . .

# Instalar dependencias PHP
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Crear directorio storage con permisos
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache && \
    chmod -R 775 storage bootstrap/cache

# Instalar dependencias Node y compilar assets
RUN npm install && npm run build

# Crear archivo .env si no existe
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Generar clave de aplicación
RUN php artisan key:generate --force

# Exponer puerto
EXPOSE 8000

# Script de inicio
CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"]
