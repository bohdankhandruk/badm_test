#!/bin/bash

docker-compose up -d --build
#docker exec -it badm_test_php /bin/bash -c "composer create-project laravel/laravel /usr/share/nginx/web"
docker exec -it badm_test_web /bin/bash -c "chown -R www-data:www-data /usr/share/nginx/web"
