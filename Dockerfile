FROM php:8.1-apache

# Install ekstensi GD dan dependency-nya
RUN apt-get update && apt-get install -y \
    libjpeg-dev libpng-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# (Opsional) tambahkan ekstensi lain jika dibutuhkan oleh CI3
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Salin semua file project ke folder web Apache
COPY . /var/www/html/

# Ubah izin agar www-data bisa akses
RUN chown -R www-data:www-data /var/www/html
