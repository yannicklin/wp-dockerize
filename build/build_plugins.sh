#! /bin/sh -eux

echo "###### Nasty custom things #########"

# Hack for plugin dependencies
mkdir -p /var/www/html/${CONTENT_FOLDERNAME}/mu-plugins
cp /root/build/000-loader.php /var/www/html/${CONTENT_FOLDERNAME}/mu-plugins/000-loader.php

mv /var/www/html/wp-content /var/www/html/${CONTENT_FOLDERNAME}
# All plugins should go in ${CONTENT_FOLDERNAME}/plugins/

cd /root/build/src/plugins
composer install --no-dev
chown -R nginx:nginx ./plugins
chmod -R 755 ./plugins
unzip -o packaged/atlas-acf-icons.zip -d ./plugins
unzip -o packaged/block-preview.zip -d ./plugins
unzip -o packaged/wpdatatables.zip -d ./plugins
cp -r ctm-customer-account ./plugins
cp -r /root/build/src/plugins/plugins /var/www/html/${CONTENT_FOLDERNAME}

# Clean those files such as package-lock.json & composer.lock
find /var/www/html/${CONTENT_FOLDERNAME}/plugins/ -name "*-lock.json" | xargs -r rm -r
find /var/www/html/${CONTENT_FOLDERNAME}/plugins/ -name "*.lock" | xargs -r rm -r

# Clean node packages, for less potential security risk
find /var/www/html/${CONTENT_FOLDERNAME}/plugins/ -type d -name "node_modules" | xargs -r rm -r

echo "DONE! (Plugins)"