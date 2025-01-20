FROM php:8.2-fpm

ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y libpq-dev git unzip && \
    docker-php-ext-install pdo pdo_pgsql

RUN pecl install redis \
    && docker-php-ext-enable redis

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Add User
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user && \
    chown -R $user:$user /var/www/html

# Add User
WORKDIR /var/www/html

USER $user

COPY . .

# Install Laravel dependencies
RUN composer install

#COPY --chmod=07777  /var/www/html/storage -R
RUN chmod -R 775 /var/www/html/storage

COPY ./entrypoint.sh /app/entrypoint.sh
RUN chmod +x /app/entrypoint.sh
RUN php artisan config:clear
ENTRYPOINT ["/app/entrypoint.sh"]

EXPOSE 8000

#ENTRYPOINT php artisan serve --host=0.0.0.0
CMD ["php", "artisan", "serve", "--host=0.0.0.0"]

