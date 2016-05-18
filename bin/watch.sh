#!/bin/bash

cd /usr/share/nginx/owt
./node_modules/ntypescript/bin/tsc --outDir web/app/dist -w &
sass --watch ./web/style/base.scss:web/static/css/style.css