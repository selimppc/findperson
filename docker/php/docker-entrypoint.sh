#!/bin/sh

## starting nginx
/usr/sbin/nginx
/usr/sbin/cron

exec docker-php-entrypoint "$@"

