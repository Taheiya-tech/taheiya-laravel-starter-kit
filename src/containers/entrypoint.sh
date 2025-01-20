#!/bin/bash

# Default values if not passed during the build
APP_NAME=${APP_NAME:-"Laravel"}
APP_ENV=${APP_ENV:-"local"}
APP_KEY=${APP_KEY:-"$(php artisan key:generate --show)"}
APP_DEBUG=${APP_DEBUG:-"true"}
APP_URL=${APP_URL:-"http://localhost"}



DB_HOST=${DB_HOST:-"localhost"}
DB_PORT=${DB_PORT:-"3306"}
DB_DATABASE=${DB_DATABASE:-"laravel_db"}
DB_USERNAME=${DB_USERNAME:-"root"}
DB_PASSWORD=${DB_PASSWORD:-"secret"}
DB_CONNECTION=${DB_CONNECTION:-"secret"}

# Generate the .env file dynamically
cd /var/www/html
cp .env.example .env

# Step 2: Overwrite specific keys with dynamic values

# Use sed to overwrite specific values in .env
sed -i "s/^APP_NAME=.*/APP_NAME=$APP_NAME/" .env
sed -i "s/^APP_ENV=.*/APP_ENV=$APP_ENV/" .env
sed -i "s/^APP_KEY=.*/APP_KEY=$APP_KEY/" .env
sed -i "s/^APP_DEBUG=.*/APP_DEBUG=$APP_DEBUG/" .env
sed -i "s/^APP_URL=.*/APP_URL=$APP_URL/" .env

sed -i "s/^DB_CONNECTION=.*/DB_CONNECTION=$DB_CONNECTION/" .env
sed -i "s/^DB_HOST=.*/DB_HOST=$DB_HOST/" .env
sed -i "s/^DB_PORT=.*/DB_PORT=$DB_PORT/" .env
sed -i "s/^DB_DATABASE=.*/DB_DATABASE=$DB_DATABASE/" .env
sed -i "s/^DB_USERNAME=.*/DB_USERNAME=$DB_USERNAME/" .env
sed -i "s/^DB_PASSWORD=.*/DB_PASSWORD=$DB_PASSWORD/" .env

php artisan migrate || "done";
php artisan storage:link || "done";
composer dump-autoload || "done";

# Now execute the original command (php-fpm)
exec "$@"
