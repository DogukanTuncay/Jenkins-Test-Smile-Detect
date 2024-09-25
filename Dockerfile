# Temel imaj olarak PHP-FPM kullanılıyor
FROM php:8.2-fpm

# Gerekli uzantıları yükleyin
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo_mysql


# Gerekli uzantıları yükle
RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get clean && rm -rf /var/lib/apt/lists/*



# Proje dosyalarını kopyala
COPY . .

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user RUN mkdir -p /home/$user/.composer && chown -R $user:$user /home/$user

# Çalışma dizinini ayarla
WORKDIR /var/www

USER $user

# Sunucuyu başlat
CMD ["php-fpm"]
