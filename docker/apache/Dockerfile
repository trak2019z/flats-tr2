FROM httpd:latest

RUN apt-get update

RUN apt-get install -y nano mc aptitude curl gnupg2 ca-certificates

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN curl -sS http://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

RUN apt-get update
RUN apt-get install -y nodejs yarn

COPY ./docker/apache/httpd.conf /usr/local/apache2/conf/flats.conf
RUN cat /usr/local/apache2/conf/flats.conf >> /usr/local/apache2/conf/httpd.conf

WORKDIR /var/www/symfony