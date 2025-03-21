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

aws s3 cp s3://ctm-enterprise-wordpress-common/feature_backup/${CNAME}/sql/wordpress_${environment}.sql dump_feature.sql
echo "Renaming SQL as recovery is coming from another environment"
old_domain=$(domain ${environment})
new_domain=$(domain ${local_env})
echo "sed -i \"s/${old_domain}/${new_domain}/gi\" dump_feature.sql"
sed -i "s/${old_domain}/${new_domain}/gi" dump_feature.sql

mysql -u $(cat /mnt/secrets-store/mariadb-username) -h $(cat /mnt/secrets-store/mariadb-host) -p$(cat /mnt/secrets-store/mariadb-password) wordpress < dump_feature.sql
aws s3 sync --exclude "*simply-static/*" s3://ctm-enterprise-wordpress-common/feature_backup/${CNAME}/${environment}/uploads /var/www/html/static-content/uploads