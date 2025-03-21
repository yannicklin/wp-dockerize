buildenv=${1}

if [ $buildenv == "LOCALHOST" ]
then
  echo "It's Localhost ENV."
  openssl req -x509 -newkey rsa:4096 -sha256 -days 365 \
      -nodes -keyout /etc/ssl/private/xxx.xxx.xxx.key -out /etc/ssl/certs/xxx.xxx.xxx.crt -subj "/CN=localhost" \
      -addext "subjectAltName=DNS:localhost,IP:127.0.0.1"
else
  echo "It's NOT Localhost ENV, it's ${buildenv}"
  openssl req -x509 -newkey rsa:4096 -sha256 -days 3650 \
      -nodes -keyout /etc/ssl/private/xxx.xxx.xxx.key -out /etc/ssl/certs/xxx.xxx.xxx.crt -subj "/CN=wordpress.xxx.xxx.xxx" \
      -addext "subjectAltName=DNS:wordpress.stg.xxx.xxx.xxx,DNS:*.dev.xxx.xxx.xxx"
fi

chown nginx:nginx /etc/ssl/private/xxx.xxx.xxx.key