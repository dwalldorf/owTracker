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
echo "preparing static vendor files..."
echo
./bin/console app:prepareWebDist