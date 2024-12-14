#!/bin/bash

# Wait for the database to be ready (optional, if you have a database service)
# sleep 10

# Run migrations
php artisan migrate --force

# Seed the database
php artisan db:seed --force

# Start the PHP-FPM server
php-fpm
