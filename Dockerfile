FROM phpdockerio/php71-fpm:latest

RUN apt-get update \
    && apt-get -y --no-install-recommends install  php-xdebug \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/* \
    && echo "xdebug.enable=1" >> /etc/php/7.1/fpm/php.ini \
    && echo "xdebug.remote_enable=1" >> /etc/php/7.1/fpm/php.ini \
    && echo "xdebug.remote_connect_back=1" >> /etc/php/7.1/fpm/php.ini \
    && echo "xdebug.remote_host=10.254.254.254" >> /etc/php/7.1/fpm/php.ini \
    && echo "xdebug.remote_port=9089" >> /etc/php/7.1/fpm/php.ini \
    && echo "xdebug.idekey=PHPSTORM" >> /etc/php/7.1/fpm/php.ini

WORKDIR "token"