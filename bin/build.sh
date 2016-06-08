#!/bin/bash

cd /usr/share/nginx/owt

npm install
composer install

./node_modules/ntypescript/bin/tsc --outDir web/app/dist

./bin/console cache:clear --env=dev
./bin/console cache:clear --env=prod
./bin/console cache:warmup --env=dev
./bin/console cache:warmup --env=prod

./bin/console assets:install --env=dev
./bin/console assets:install --env=prod

./bin/console owt:createIndices