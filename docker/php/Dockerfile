FROM php:8.1-fpm-buster
ARG TIMEZONE

COPY docker/php/conf.d/php.ini /usr/local/etc/php/conf.d/docker-php-config.ini
COPY docker/php/conf.d/apcu.ini /usr/local/etc/php/conf.d/
COPY docker/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/

RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    wget \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN docker-php-ext-configure gd --with-jpeg --with-freetype

RUN docker-php-ext-install \
    pdo pdo_mysql zip xsl gd intl opcache exif mbstring

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

RUN wget --no-check-certificate https://phar.phpunit.de/phpunit-6.5.3.phar && \
    mv phpunit*.phar phpunit.phar && \
    chmod +x phpunit.phar && \
    mv phpunit.phar /usr/local/bin/phpunit

RUN mkdir -p /var/www/symfony
# Add UID '1000' to www-data
RUN usermod -u 1000 www-data
# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/symfony
# Change current user to www
USER www-data

WORKDIR /var/www/symfony

COPY . .
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
