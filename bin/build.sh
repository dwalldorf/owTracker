#!/bin/bash

cd /vagrant

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
echo "symfony cache warmup..."
echo
./bin/console cache:warmup