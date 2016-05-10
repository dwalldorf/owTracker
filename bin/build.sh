#!/bin/bash

cd /vagrant

echo
echo "npm install..."
echo
#npm install

echo
echo
echo
echo "composer install..."
echo
#composer install

echo
echo
echo
echo "building frontend..."
echo
/vagrant/node_modules/ntypescript/bin/tsc --out scripts
