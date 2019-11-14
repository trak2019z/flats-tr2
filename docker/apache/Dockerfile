FROM httpd:latest

RUN apt-get update

RUN apt-get install -y nano mc aptitude

COPY ./httpd.conf /usr/local/apache2/conf/flats.conf
RUN cat /usr/local/apache2/conf/flats.conf >> /usr/local/apache2/conf/httpd.conf