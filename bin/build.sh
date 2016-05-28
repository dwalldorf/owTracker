#!/bin/bash

cd /usr/share/nginx/owt

npm install
composer install

./node_modules/ntypescript/bin/tsc --outDir web/app/dist
./bin/console owt:createIndices