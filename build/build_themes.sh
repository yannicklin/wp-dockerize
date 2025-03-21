#! /bin/sh -eux

# All themes should go in ${CONTENT_FOLDERNAME}/themes/, also clean out the remaining node packages
cp -r /root/build/src/themes /var/www/html/${CONTENT_FOLDERNAME}/
rm -rf /var/www/html/${CONTENT_FOLDERNAME}/themes/compare-the-market/node_modules/

cd /var/www/html/${CONTENT_FOLDERNAME}/themes/compare-the-market
composer install --no-dev
npm install
npm run build
cd -

# Clean those files such as package-lock.json & composer.lock
find /var/www/html/${CONTENT_FOLDERNAME}/themes/compare-the-market/ -name "*-lock.json" | xargs -r rm -r
find /var/www/html/${CONTENT_FOLDERNAME}/themes/compare-the-market/ -name "*.lock" | xargs -r rm -r

# Clean node packages, for less potential security risk
rm -rf /var/www/html/${CONTENT_FOLDERNAME}/themes/compare-the-market/node_modules/

echo "DONE! (Theme)"