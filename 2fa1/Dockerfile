FROM php:8.1-apache

# Cài đặt các extension cần thiết
RUN docker-php-ext-install mysqli

# Copy mã nguồn vào container
COPY . /var/www/html

# Cấp quyền cho thư mục
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80