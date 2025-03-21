#!/usr/bin/env bash

#mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# https://www.php.net/manual/en/errorfunc.constants.php
# https://github.com/docker-library/wordpress/issues/420#issuecomment-517839670
cat << 'EOF' > /etc/php82/conf.d/error-logging.ini
error_reporting = E_ERROR | E_WARNING | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING | E_RECOVERABLE_ERROR
display_errors = Off
display_startup_errors = Off
log_errors = On
error_log = /dev/stderr
log_errors_max_len = 1024
ignore_repeated_errors = On
ignore_repeated_source = Off
html_errors = Off
EOF

cat << 'EOF' > /etc/php82/conf.d/uploads.ini
upload_max_filesize = 32M
post_max_size = 32M
EOF

cat << 'EOF' > /etc/php82/conf.d/execution.ini
max_execution_time = 600
EOF

cat << 'EOF' > /etc/php82/conf.d/memory.ini
memory_limit = 256M
EOF

ln -s /usr/bin/php82 /usr/bin/php
ln -s /usr/bin/php-config82 /usr/bin/php-config

sed -i \
    -e "s/;chdir.*/chdir = \/var\/www/" \
    -e "s/listen =.*/listen = 9090/" \
    -e "s/;pm.max_requests.*/pm.max_requests = 1000/" \
    -e "s/;pm.status_path.*/pm.status_path = \/fpm-status/" \
    -e "s/;pm.status_listen.*/pm.status_listen = 9091/" \
    -e "s/;ping.path.*/ping.path = \/ping/" \
    -e "s/user.*/user = nginx/" \
    -e "s/group.*/group = nginx/" \
    -e "s/;access.log.*/access.log = \/dev\/stdout/" \
    -e "s/;clear_env.*/clear_env = no/" \
    -e "s/;sys_temp_dir.*/sys_temp_dir = \/tmp/" \
    /etc/php82/php-fpm.d/www.conf

sed -i \
    -e "s/;error_log.*/error_log = \/dev\/stderr/" \
    /etc/php82/php-fpm.conf