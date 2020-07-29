FROM php:7.3-apache

RUN apt update \
	&& apt install -y libicu-dev \
		git \
		wget \
		zlib1g-dev \
        libzip-dev \
        openssh-client

RUN curl -s https://getcomposer.org/installer > composer-setup.php \
       && php composer-setup.php --install-dir=/usr/bin --filename=composer \
       && wget https://get.symfony.com/cli/installer -O - | bash \
       && echo 'export PATH="$HOME/.symfony/bin:$PATH"' >> /root/.bashrc \
       && mv /root/.symfony/bin/symfony /usr/local/bin/symfony;

RUN pecl install xdebug-2.8.1 \
	&& docker-php-ext-enable xdebug \
	&& a2enmod rewrite \
	&& docker-php-ext-install pdo_mysql intl zip opcache

#RUN apt install -y cron vim

COPY ./environment/php.ini $PHP_INI_DIR/php.ini
#COPY ./environment/app.sh /usr/bin/app.sh
#COPY ./environment/crontab /var/spool/cron/crontabs/root

# инициализация внешнего файла
#RUN crontab /var/spool/cron/crontabs/root

COPY ./environment/httpd.conf /etc/apache2/sites-available/000-default.conf