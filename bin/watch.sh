#!/bin/bash

/vagrant/node_modules/ntypescript/bin/tsc --outDir web/app/dist -w &
sass --watch /vagrant/web/style/base.scss:/vagrant/web/static/css/style.css