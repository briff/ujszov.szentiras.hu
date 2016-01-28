#!/bin/bash
npm install
node_modules/.bin/bower --config.interactive=false install
node_modules/.bin/gulp
php composer.phar install
php artisan migrate --force
