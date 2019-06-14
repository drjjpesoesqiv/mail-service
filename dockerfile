FROM php:7.2-apache
COPY src/ /var/www/html/
RUN apt-get update && \
   apt-get install -y ssmtp && \
   apt-get clean

COPY ssmtp.conf /etc/ssmtp/ssmtp.conf

RUN echo 'sendmail_path = "/usr/sbin/ssmtp -t -i"' > /usr/local/etc/php/conf.d/mail.ini
RUN chfn -f "No Reply" www-data
