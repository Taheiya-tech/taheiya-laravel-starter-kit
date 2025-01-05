FROM php:8.2-fpm

ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y libpq-dev git unzip && \
    docker-php-ext-install pdo pdo_pgsql

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Add User
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

WORKDIR /var/www

USER $user

COPY . .

# Install Laravel dependencies
RUN composer install

#RUN php artisan serve
RUN php artisan storage:link
RUN composer dump-autoload
RUN php artisan key:generate
CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]

