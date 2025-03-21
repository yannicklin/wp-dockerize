#!/usr/bin/env bash

#https://gist.github.com/aramalipoor/a981ebfd94a5920df4b958d8a6b9ad70
mkdir -p /var/log/newrelic /var/run/newrelic
touch /var/log/newrelic/php_agent.log /var/log/newrelic/newrelic-daemon.log
chmod -R g+ws /tmp /var/log/newrelic/ /var/run/newrelic/
chown -R 1001:0 /tmp /var/log/newrelic/ /var/run/newrelic/

# Download and install Newrelic binary
cd /tmp
export NEWRELIC_VERSION=$(curl -sS https://download.newrelic.com/php_agent/release/ | sed -n 's/.*>\(.*linux-musl\).tar.gz<.*/\1/p')
echo ${NEWRELIC_VERSION}
curl -s -O https://download.newrelic.com/php_agent/release/${NEWRELIC_VERSION}.tar.gz
gzip -dc ${NEWRELIC_VERSION}.tar.gz | tar xf -
cd "${NEWRELIC_VERSION}"
NR_INSTALL_SILENT=1 NR_INSTALL_USE_CP_NOT_LN=1 NR_INSTALL_PATH=/usr/bin NR_INSTALL_KEY=ca5c0d203de3ebba4062e3bb7ef0b6f8FFFFNRAL ./newrelic-install install
rm -f /var/run/newrelic-daemon.pid
rm -f /tmp/.newrelic.sock
ls -lA /etc/php82/conf.d/

sed -i \
    -e "s/;newrelic.enabled =.*/newrelic.enabled = true/" \
    -e "s/;newrelic.loglevel =.*/newrelic.loglevel = info/" \
    -e "s/;newrelic.daemon.loglevel =.*/newrelic.daemon.loglevel = info/" \
    -e "s/;newrelic.framework =.*/newrelic.framework = \"wordpress\"/" \
    -e "s/newrelic.logfile =.*/newrelic.logfile = \"\/dev\/stdout\"/" \
    -e "s/newrelic.daemon.logfile =.*/newrelic.daemon.logfile = \"\/dev\/stdout\"/" \
    /etc/php82/conf.d/newrelic.ini

chown nginx:nginx /etc/php82/conf.d/newrelic.ini
chown nginx:nginx /etc/php82/conf.d

