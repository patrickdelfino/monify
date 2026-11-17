#!/bin/sh
set -eu

cd /var/www/html
attempt=0
until [ -f wp-config.php ] && [ -f wp-includes/version.php ]; do
    attempt=$((attempt + 1))
    if [ "$attempt" -ge 60 ]; then
        echo 'O WordPress ainda não foi inicializado.' >&2
        exit 1
    fi
    sleep 2
done

if ! wp core is-installed; then
    wp core install --url="http://localhost:$MONIFY_PORT" --title='Monify' \
        --admin_user=monify-admin --admin_email=monify@example.test \
        --admin_password="$MONIFY_ADMIN_PASSWORD" --skip-email
fi

wp theme activate monify
wp eval-file /demo/seed.php
wp rewrite structure '/%postname%/' --hard
wp rewrite flush --hard
printf '\nCatálogo disponível em http://localhost:%s\n' "$MONIFY_PORT"
