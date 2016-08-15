FROM debian:jessie

MAINTAINER Smash Dev Shop version: 0.1

ENV code_root /var/www
ENV httpd_conf ${code_root}/docker_config/vhosts.conf

RUN apt-get update && \
    apt-get install -y --force-yes \
            apache2 \
        php5 \
		php5-cli \
        php5-curl \
        php5-gd \
		libapache2-mod-php5 \
		php5-mcrypt \
		php5-mysqlnd \
        nano

RUN a2enmod \
            php5 \
        rewrite

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP    www-data
ENV APACHE_LOG_DIR  /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid

RUN sed -i -e "s|^;date.timezone =.*$|date.timezone = America/Chicago |" /etc/php5/apache2/php.ini
ADD . $code_root
RUN test -e $httpd_conf && echo "Include $httpd_conf" >> /etc/apache2/apache2.conf

EXPOSE 80
EXPOSE 443

CMD /usr/sbin/apache2ctl -D FOREGROUND

RUN usermod -u 1000 www-data
RUN usermod -G staff www-data