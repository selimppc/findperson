FROM php:8.0-rc-fpm

RUN apt-get update && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip libpq-dev librabbitmq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install intl opcache pdo pdo_mysql pdo_pgsql pgsql \
    && pecl install apcu \
    && pecl install mongodb \
    && pecl install amqp \
    && pecl install redis \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

WORKDIR /var/www/project

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN echo "extension=mongodb.so" >> /etc/php.ini
RUN echo "extension=redis.so" >> /etc/php.ini
RUN echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/docker-php-ext-apcu.ini
RUN echo "extension=amqp.so" >> /usr/local/etc/php/conf.d/docker-php-ext-apcu.ini

## MEMORY
RUN cd /usr/local/etc/php/conf.d/ && \
  echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-ram-limit.ini

## composer install \
# RUN composer.phar install --no-interaction --no-dev --optimize-autoloader

EXPOSE 80

## ENTRYPOINT ["./docker-entrypoint.sh"]
HEALTHCHECK --interval=20s --timeout=3s --retries=3 --start-period=20s CMD curl --fail http://localhost || exit 1
CMD ["php-fpm"]
