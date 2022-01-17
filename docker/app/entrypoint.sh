#!/bin/sh
composer install
chmod 777 -R var/*
chmod 777 -R public/uploads/*
bin/console lexik:jwt:generate-keypair
bin/console d:m:m
bin/console --env=test doctrine:database:create
bin/console --env=test doctrine:schema:create
bin/console --env=test d:m:m
bin/console doctrine:fixtures:load --env=test --purge-with-truncate --no-interaction
bin/console cache:clear

exec "$@"
