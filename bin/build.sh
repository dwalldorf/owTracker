#!/bin/bash

cd /usr/share/nginx/owt

./bin/service-restart.sh

npm install
composer install

./node_modules/ntypescript/bin/tsc --outDir web/app/dist

rm -rf ./var/cache/*
./bin/console cache:warmup --env=dev
./bin/console cache:warmup --env=prod

./bin/console assets:install --env=dev
./bin/console assets:install --env=prod

./bin/console owt:createIndices