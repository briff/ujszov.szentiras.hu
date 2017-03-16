#!/bin/bash
npm --no-bin-link install
node_modules/bower/bin/bower --config.interactive=false install
php composer.phar install
node_modules/gulp/bin/gulp.js
php artisan migrate --force
php artisan cache:clear
php artisan twig:clean
