# Usar uma imagem base do PHP com Apache
FROM php:8.3-apache

# Copiar todos os arquivos para o diretório do servidor
COPY . /var/www/html

# Instalar extensões necessárias (exemplo: pdo_mysql para MySQL)
RUN docker-php-ext-install pdo pdo_mysql

# Expor a porta 8080 (usada pelo Render)
EXPOSE 8080

# Configurar o ponto de entrada
CMD ["php", "-S", "0.0.0.0:8080", "-t", "/var/www/html"]
