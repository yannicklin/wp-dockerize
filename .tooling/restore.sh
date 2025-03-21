#!/usr/bin/env bash -eux

cd /tmp

environment=${1}
local_env=$(echo ${ENV} | tr '[:upper:]' '[:lower:]')

function domain() {
    x=${1}
    case $x in
    prd)
      echo "wordpress.xxx.xxx.xxx"
      ;;
    stg)
      echo "wordpress.stg.xxx.xxx.xxx"
      ;;
    dev)
      echo "${CNAME}.dev.xxx.xxx.xxx"
      ;;
    esac
}

check=$(echo "show tables;" |mysql -u $(cat /mnt/secrets-store/mariadb-username) -h $(cat /mnt/secrets-store/mariadb-host) -p$(cat /mnt/secrets-store/mariadb-password) wordpress)
# If there are tables, we don't want to try to trigger the restore
if [[ ! -z "$check" ]]; then
  echo "Data already exists, cancelling restore";
  exit 0;
else
  aws s3 cp s3://ctm-enterprise-wordpress-common/backup/sql/wordpress_${environment}.sql dump.sql
  if [[ ${local_env} != ${environment} ]]
  then
    echo "Renaming SQL as recovery is coming from another environment"
    old_domain=$(domain ${environment})
    new_domain=$(domain ${local_env})
    echo "sed -i \"s/${old_domain}/${new_domain}/gi\" dump.sql"
    sed -i "s/${old_domain}/${new_domain}/gi" dump.sql
  fi

  mysql -u $(cat /mnt/secrets-store/mariadb-username) -h $(cat /mnt/secrets-store/mariadb-host) -p$(cat /mnt/secrets-store/mariadb-password) wordpress < dump.sql

  aws s3 sync --exclude "*simply-static/*" s3://ctm-enterprise-wordpress-common/backup/${environment}/uploads /var/www/html/static-content/uploads

fi