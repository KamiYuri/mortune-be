FROM php:8.1-fpm

RUN apt update -y

RUN apt install -y --no-install-recommends \
    git wget curl\
    openssl build-essential re2c libxml2-dev bison pkg-config libbz2-dev libjpeg-dev libpng-dev libmcrypt-dev libtidy-dev libxslt1-dev autoconf libzip-dev libreadline-dev libonig-dev libssl-dev libsqlite3-dev libcurl4-openssl-dev locales
# php-common php-curl php-json \
# php-mbstring php-mysql php-xml php-zip

# compile native PHP packages
RUN docker-php-ext-install \
    # gd \
    pcntl \
    bcmath \
    mysqli \
    pdo_mysql

# configure packages

RUN pecl install zip && docker-php-ext-enable zip \
    && pecl install xdebug && docker-php-ext-enable xdebug

# set locale to utf-8
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && locale-gen
ENV LANG='en_US.UTF-8' LANGUAGE='en_US:en' LC_ALL='en_US.UTF-8'

# add zsh


RUN sh -c "$(wget -O- https://github.com/deluan/zsh-in-docker/releases/download/v1.1.4/zsh-in-docker.sh)" -- \
    -p artisan
RUN git clone https://github.com/jessarcher/zsh-artisan.git $HOME/.oh-my-zsh/custom/plugins/artisan


#--------------------------------------------------------------------------
# Final Touches
#--------------------------------------------------------------------------

# install composer
RUN EXPECTED_CHECKSUM="55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae" && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")" && \
    if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]; then >&2 echo 'ERROR: Invalid installer checksum' && exit 1; fi

RUN php composer-setup.php --quiet && rm composer-setup.php && \
    mv composer.phar /usr/local/sbin/composer && \
    chmod +x /usr/local/sbin/composer

# Add default configuration files
ADD configs/php.ini /usr/local/etc/php/
ADD configs/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
ADD configs/error_reporting.ini /usr/local/etc/php/conf.d/error_reporting.ini

# Clean up
RUN apt-get remove -y git && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www/html

RUN chsh -s $(which zsh)
