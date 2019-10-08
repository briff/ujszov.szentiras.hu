#!/bin/bash
npm install
node_modules/bower/bin/bower --config.interactive=false install
php composer.phar install
node_modules/gulp/bin/gulp.js
php56 artisan migrate --force
php56 artisan cache:clear
php56 artisan twig:clean
