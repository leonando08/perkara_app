# Dockerfile untuk CodeIgniter + Apache + PHP
FROM php:8.1-apache

# Install ekstensi PHP yang dibutuhkan
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli


# Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# Set session.save_path ke /tmp agar session PHP bisa berjalan di Docker
RUN echo 'session.save_path = "/tmp"' > /usr/local/etc/php/conf.d/docker-session.ini

# Copy source code ke /var/www/html
COPY . /var/www/html/

# Set permission
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Ubah DocumentRoot jika perlu (default: /var/www/html)
# ENV APACHE_DOCUMENT_ROOT /var/www/html

# Konfigurasi .htaccess untuk CodeIgniter (jika belum ada)
# Pastikan AllowOverride All di /etc/apache2/apache2.conf untuk /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
