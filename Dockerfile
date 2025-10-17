# ==========================
# ETAPA 1 - BUILD DA APLICAÇÃO
# ==========================
FROM php:8.2-cli AS builder

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
FROM php:8.2-cli AS runtime

# Define diretório de trabalho
WORKDIR /var/www

# Copia aplicação do builder
COPY --from=builder /var/www /var/www

# Define permissões corretas
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Gera APP_KEY automaticamente (caso não exista)
RUN php artisan key:generate --force || true

# Expõe porta que o Laravel irá escutar
ENV PORT=10000
EXPOSE ${PORT}

# Entrypoint: roda migrations e inicia o Laravel Built-in Server
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=${PORT}
