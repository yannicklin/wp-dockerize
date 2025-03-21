local_env=$(echo ${ENV} | tr '[:upper:]' '[:lower:]')

if [[ ${local_env} == "dev" && ${CNAME} != "wordpress.dev.xxx.xxx.xxx" ]] then
  cd /tmp

  mysqldump -u $(cat /mnt/secrets-store/mariadb-username) -h $(cat /mnt/secrets-store/mariadb-host) -p$(cat /mnt/secrets-store/mariadb-password) --single-transaction wordpress > dump_feature.sql
  aws s3 cp dump_feature.sql s3://ctm-enterprise-wordpress-common/feature_backup/${CNAME}/sql/wordpress_${local_env}.sql
  aws s3 presign s3://ctm-enterprise-wordpress-common/feature_backup/${CNAME}/sql/wordpress_${local_env}.sql --expires-in 259200

  aws s3 sync --exclude "*simply-static/*" /var/www/html/static-content/uploads s3://ctm-enterprise-wordpress-common/feature_backup/${CNAME}/${local_env}/uploads
  cd /var/www/html/static-content/uploads
  zip -r /tmp/uploads.zip . -x "simply-static/*"
  aws s3 cp /tmp/uploads.zip s3://ctm-enterprise-wordpress-common/feature_backup/${CNAME}/${local_env}/uploads.zip
  aws s3 presign s3://ctm-enterprise-wordpress-common/feature_backup/${CNAME}/${local_env}/uploads.zip --expires-in 259200
  rm /tmp/uploads.zip
  exit 0
fi