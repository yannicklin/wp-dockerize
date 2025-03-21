#!/usr/bin/env bash -eux

local_env=$(echo ${ENV} | tr '[:upper:]' '[:lower:]')

cd /tmp

mysqldump -u $(cat /mnt/secrets-store/mariadb-username) -h $(cat /mnt/secrets-store/mariadb-host) -p$(cat /mnt/secrets-store/mariadb-password) --single-transaction wordpress > dump.sql
aws s3 cp dump.sql s3://ctm-enterprise-wordpress-common/backup/sql/wordpress_${local_env}.sql

aws s3 sync --exclude "*simply-static/*" /var/www/html/static-content/uploads s3://ctm-enterprise-wordpress-common/backup/${local_env}/uploads
