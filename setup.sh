#!/bin/bash

docker-compose up -d --build
docker exec -it badm_test_php /bin/bash -c "cd /usr/share/nginx/web/ && composer install"
docker exec -it badm_test_web /bin/bash -c "chown -R www-data:www-data /usr/share/nginx/web"
