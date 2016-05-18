#!/bin/bash

cd /usr/share/nginx/owt

echo
echo "npm install..."
echo
npm install

echo
echo
echo
echo "composer install..."
echo
composer install

echo
echo
echo
echo "building frontend..."
echo
./node_modules/ntypescript/bin/tsc --outDir web/app/dist
