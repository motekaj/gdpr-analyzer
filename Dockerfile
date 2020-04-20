FROM yiisoftware/yii2-php:7.2-apache

COPY ./ /app/
RUN chown -R www-data:www-data /app
RUN cd /app && composer install