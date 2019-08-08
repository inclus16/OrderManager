#!/usr/bin/env bash

if [[ $1 == 'build' ]]; then
    docker-compose build
fi;
docker-compose up -d
echo "Composer install..."
docker-compose exec php composer install
echo "Start migrations..."
docker-compose exec php php artisan migrate
echo "Start seeding"
docker-compose exec php php artisan db:seed
echo "All done!"