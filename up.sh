#!/usr/bin/env bash

if [[ $1 == 'build' ]]; then
    docker-compose build
fi;
docker-compose up -d
echo "Start migrations..."
docker-compose exec php php artisan migrate
echo "Migrations complete!"
echo "Start seeding"
docker-compose exec php php artisan db:seed
echo "Complete seeding!"