#!/bin/sh

# Démarrer php-fpm
php-fpm -D

# Démarrer nginx
nginx -g "daemon off;" 