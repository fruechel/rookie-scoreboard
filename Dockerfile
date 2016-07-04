FROM php:5-fpm
MAINTAINER Florian Ruechel <fruechel@atlassian.com>

# Set up a user so we don't run as root
RUN mkdir /app
RUN groupadd -r app && useradd -rm -g app app
RUN chown -R app:app /app
RUN apt-get update
RUN apt-get install -y php5-pgsql libpq-dev postgresql-client
RUN docker-php-ext-install pdo_pgsql

WORKDIR /app
COPY lib /app/lib
COPY pages /app/pages
COPY static /app/static
COPY templates /app/templates
COPY config.micros.php /app/config.php
COPY index.php logic.php /app/
COPY startup.sh /app/
COPY install /app/install

CMD ["sh", "startup.sh"]
