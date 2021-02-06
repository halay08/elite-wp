#!/bin/bash

ROOT_PATH="${1:-$LANDO_MOUNT}"
cd $ROOT_PATH

if [[ -z "$ROOT_PATH" ]]; then
    echo "Error: Must be run the appserver.";
    exit 1
fi

composer update --prefer-source

printf "\n***************************************************************************\n"
printf "                   Install Elite Landing page using WordPress Latest\n"
printf "***************************************************************************\n\n"

#wp --allow-root core download --force

if ! wp --allow-root core is-installed; then
    wp --allow-root core install \
        --url="$WORDPRESS_HTTP_HOST" \
        --title="$WORDPRESS_TITLE" \
        --admin_user="$WORDPRESS_ADMIN_USER" \
        --admin_password="$WORDPRESS_ADMIN_PASSWORD" \
        --admin_email="$WORDPRESS_ADMIN_EMAIL" \
        --skip-email
fi

# Install third-party plugins
echo "Installing wordpress plugins..."
wp --allow-root plugin install --activate advanced-custom-fields-pro \
    elementor \
    unyson \
    ecademy-toolkit \
    contact-form-7 \
    front-end-pm \
    learnpress \
    learnpress-course-review \
    newsletter \
    tutor \
    wp-events-manager \
    woocommerce

# Delete unused plugins
wp --allow-root plugin delete hello

# Install dependencies
./scripts/build_deps.sh $ROOT_PATH

# Activate current theme
wp --allow-root theme activate ecademy

# Delete default wp --allow-root themes
echo "Deleting default themes..."
wp --allow-root theme delete twentyeleven twentyfifteen twentyfourteen twentynineteen twentyseventeen \
    twentysixteen twentyten twentythirteen twentytwelve twentytwenty twentytwentyone