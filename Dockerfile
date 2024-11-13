# Stage 1: Build stage
FROM composer:2 AS build

LABEL maintainer="yaangvu@gmail.com"

ENV APP_ROOT /var/www/html
ENV APP_TIMEZONE UTC

WORKDIR ${APP_ROOT}

# Set TimeZone
ENV TZ=${APP_TIMEZONE}
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Copy the application files
COPY . .

# Install PHP dependencies
RUN composer install --ignore-platform-req=ext-intl --ignore-platform-req=ext-gd --ignore-platform-req=ext-mongodb

# Stage 2: Production stage
FROM php:8.2-cli

LABEL maintainer="yaangvu@gmail.com"

ENV APP_ROOT /var/www/html
ENV APP_TIMEZONE UTC

WORKDIR ${APP_ROOT}

# Set TimeZone
ENV TZ=${APP_TIMEZONE}
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Config php.ini limitations
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN sed -i "s|max_execution_time = 30|max_execution_time = 60|g" "$PHP_INI_DIR/php.ini"
RUN sed -i "s|memory_limit = 128M|memory_limit = 1G|g" "$PHP_INI_DIR/php.ini"

# Config php.ini Opcache
RUN echo "opcache.enable=1" >> "$PHP_INI_DIR/php.ini"
RUN echo "opcache.memory_consumption=512" >> "$PHP_INI_DIR/php.ini"
RUN echo "opcache.interned_strings_buffer=64" >> "$PHP_INI_DIR/php.ini"
RUN echo "opcache.max_accelerated_files=32531" >> "$PHP_INI_DIR/php.ini"
RUN echo "opcache.validate_timestamps=0" >> "$PHP_INI_DIR/php.ini"
RUN echo "opcache.fast_shutdown=0" >> "$PHP_INI_DIR/php.ini"

# Add Production Dependencies. Those are necessary
RUN apt update -y
RUN apt install -y \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev \
    libzip-dev \
    zlib1g \
    ffmpeg

# Configure & Install Extension
RUN docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-configure gd --with-jpeg

RUN docker-php-ext-install \
    opcache \
    pgsql \
    gd \
    intl \
    sockets \
    zip \
    pdo_pgsql \
    pdo_mysql \
    bcmath

## Install Mongodb
RUN pecl install redis \
    && docker-php-ext-enable redis.so


# Copy the application files from the build stage
COPY --from=build ${APP_ROOT} ${APP_ROOT}

# Copy the start script
COPY dockerize/start.sh /usr/local/bin/start

# Run the command on container startup
RUN chmod u+x /usr/local/bin/start

EXPOSE 8000
CMD ["/usr/local/bin/start"]
