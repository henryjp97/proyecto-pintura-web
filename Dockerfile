FROM php:8.2-fpm

# Extensiones de PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Instalar git y unzip (los necesita Composer para descargar paquetes)
RUN apt-get update && apt-get install -y git unzip && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar composer.json e instalar dependencias
COPY composer.json ./
RUN composer install --no-interaction --no-dev --optimize-autoloader --prefer-dist