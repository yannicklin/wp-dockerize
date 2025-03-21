version=${1}
user=${2:nginx}

curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
mv wp-cli.phar /usr/local/bin/wp
mkdir -p /var/www/html/static-content
chown ${user}:${user} /var/www/html/static-content
mkdir -p /var/www/html/static-content/cache
chown ${user}:${user} /var/www/html/static-content/cache
touch /var/www/html/wp-config.php
chown ${user}:${user} /var/www/html/wp-config.php

wp core download --path=/var/www/html/ --version=${version} --allow-root
