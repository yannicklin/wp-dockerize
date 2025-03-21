# https://hub.docker.com/_/wordpress
FROM alpine:3.21.3 as php-base

RUN apk update
RUN apk add \
    nginx \
    php82-fpm \
    php82-cli \
    php82-dev \
    php82-bcmath \
    php82-bz2 \
    php82-calendar \
    php82-common \
    php82-ctype \
    php82-exif \
    php82-fileinfo \
    php82-curl \
    php82-dom \
    php82-gd \
    php82-iconv \
    php82-intl \
    php82-mbstring \
    php82-mysqli \
    php82-mysqlnd \
    php82-opcache \
    php82-openssl \
    php82-pdo_mysql \
    php82-pdo_pgsql \
    php82-pdo_sqlite \
    php82-phar \
    php82-session \
    php82-simplexml \
    php82-tokenizer \
    php82-xml \
    php82-xmlwriter \
    php82-zip \
    bash \
    curl \
    openssl \
    coreutils \
    mariadb-client \
    tar --no-cache

COPY ./build/php.sh /root/build/
RUN chmod +x /root/build/php.sh
RUN /root/build/php.sh
COPY ./build/newrelic.sh /root/build/
RUN chmod +x /root/build/newrelic.sh
RUN /root/build/newrelic.sh

FROM php-base as wordpress-base

ENV CONTENT_FOLDERNAME="static-content"

COPY ./build /root/build
COPY ./src/wpcli-packages /tmp/wpcli-packages
RUN chmod +777 /tmp/wpcli-packages
RUN chmod +x /root/build/wordpress.sh
RUN /root/build/wordpress.sh "6.5.5" "nginx"

FROM wordpress-base as base-build

# Install required dependencies
RUN apk update
RUN apk add unzip wget git npm --no-cache
RUN curl -sS https://getcomposer.org/installer -o /root/build/composer-setup.php
RUN chmod +x /root/build/composer-setup.php
RUN php /root/build/composer-setup.php --install-dir=/usr/local/bin --filename=composer

FROM base-build as req-artifacts

RUN chmod +x /root/build/build_*.sh
COPY --chown=nginx:nginx ./build/wp-config-docker.php /var/www/html/wp-config.php
COPY ./build/health.php /var/www/html/

FROM req-artifacts as http-service

COPY ./.docker/docker-entrypoint.sh /usr/local/bin/
COPY ./.docker/php-fpm-foreground /usr/local/bin/
COPY ./.nginx/nginx.conf /etc/nginx/nginx.conf
RUN chmod +x /usr/local/bin/php-fpm-foreground
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
RUN mkdir /var/www/tmp
RUN chown -R nginx:nginx /var/www/tmp
RUN chown -R nginx:nginx /var/log

ARG BUILDENV=notlocal
ENV BUILDENV=${BUILDENV}
RUN chmod +x /root/build/ssl.sh
RUN /root/build/ssl.sh $BUILDENV

COPY ./src/plugins /root/build/src/plugins
COPY ./src/themes /root/build/src/themes
RUN /root/build/build_plugins.sh
RUN /root/build/build_themes.sh
RUN cp -r /root/build/scripts /usr/local/bin/

RUN cp /root/build/post_start.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/post_start.sh

RUN rm -r /root/build

FROM http-service

#VOLUME /var/www/html

EXPOSE 8080

USER nginx
WORKDIR /var/www/html
# https://httpd.apache.org/docs/2.4/stopping.html#gracefulstop
STOPSIGNAL SIGWINCH
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["/usr/local/bin/post_start.sh"]
#CMD ["tail", "-f", "/dev/null"]