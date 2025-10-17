# ==========================
# ETAPA 1 - BUILD DA APLICAÇÃO
# ==========================
FROM php:8.2-fpm AS builder

# Instala dependências do sistema e extensões PHP
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring

# Instala o Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www

# Copia arquivos do projeto
COPY . .

# Instala dependências do Laravel (modo produção)
RUN composer install --no-dev --optimize-autoloader

# Gera cache de configuração (melhor performance)
RUN php artisan config:clear && php artisan route:clear && php artisan view:clear


# ==========================
# ETAPA 2 - PRODUÇÃO (RUNTIME)
# ==========================
FROM builder AS runtime

# Instala Nginx e supervisord (para gerenciar ambos os processos)
RUN apt-get update && apt-get install -y nginx supervisor && apt-get clean

# Copia arquivos da aplicação (do stage anterior)
COPY --from=builder /var/www /var/www

# Define diretório de trabalho
WORKDIR /var/www
COPY --from=builder /var/www /var/www

# Copia configuração customizada do Nginx
COPY ./docker/nginx/default.conf /etc/nginx/sites-available/default

# Copia configuração do supervisor
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Define permissões corretas
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Gera APP_KEY automaticamente (caso não exista)
RUN php artisan key:generate --force || true

# Expõe porta padrão HTTP
ENV PORT=10000
EXPOSE ${PORT}

# Copia o script de inicialização
COPY ./docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Usa o entrypoint personalizado
ENTRYPOINT ["/entrypoint.sh"]
