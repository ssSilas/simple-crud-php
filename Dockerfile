FROM php:7.4-apache
CMD ["mysqld"]
COPY src/ /var/www/html/
