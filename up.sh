#!/usr/bin/env bash

docker-compose down
if [[ $1 == 'build' ]]; then
    docker-compose build
fi;
docker-compose up -d
echo "Composer install..."
docker-compose exec php composer install
echo "Start migrations..."
docker-compose exec php php artisan migrate
echo "Start seeding..."
docker-compose exec php php artisan db:seed
echo "Publishing dictionaries..."
docker-compose exec php php artisan PublishDictionaries
echo "Runing http tests..."
docker-compose exec php ./vendor/bin/phpunit tests/Feature
echo "Publishing dictionaries..."
docker-compose exec php php artisan PublishDictionaries
echo "All done!"
