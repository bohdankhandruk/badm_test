#!/bin/bash

docker-compose up -d --build
docker exec -it badm_test_php /bin/bash -c "cd /usr/share/nginx/web/ && \
    composer install && \
    php artisan migrate:fresh && \
    php artisan db:seed UsersSeeder && \
    php artisan db:seed OrganizationsSeeder && \
    chown -R www-data:www-data /usr/share/nginx/web"
