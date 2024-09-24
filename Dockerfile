# Temel imaj olarak PHP-FPM kullanılıyor
FROM php:8.2-fpm

# Gerekli uzantıları yükle
RUN docker-php-ext-install pdo pdo_mysql

# Çalışma dizinini ayarla
WORKDIR /var/www

# Proje dosyalarını kopyala
COPY . .

# Composer'ı yükle ve bağımlılıkları yükle
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

# Sunucuyu başlat
CMD ["php-fpm"]
