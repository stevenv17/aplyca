FROM ubuntu:18.04
ADD . /code
WORKDIR /code

# time zone
ENV TZ=America/Bogota
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

#ubuntu
RUN apt-get -y update && apt-get -y upgrade
RUN apt-get -y install software-properties-common
RUN apt-get -y install wget
RUN apt-get -y install git

#php
RUN add-apt-repository ppa:ondrej/php -y
RUN apt-get update
RUN apt-get -y install php7.4
RUN apt-get -y install php-pear php7.4-curl php7.4-dev php7.4-gd php7.4-mbstring php7.4-zip php7.4-mysql php7.4-xml

#composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --version=1.10.19
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

#symfony
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

#instalar dependencias con composer (tal vez deberia correrlo desde adentro si aún no tengo un proyecto porque no encuentraria el composer.json)
RUN composer install


#CMD ["cron", "-f"]
CMD ["symfony", "server:start"]