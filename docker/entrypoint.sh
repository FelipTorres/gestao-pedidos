#!/bin/sh
set -e

echo "⏳ Aguardando banco de dados MySQL em ${DB_HOST}:${DB_PORT}..."

# Aguarda até o MySQL ficar acessível
until php -r "try { new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT') . ';dbname=' . getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); exit(0); } catch (Exception \$e) { echo 'Banco indisponível, tentando novamente...'; exit(1); }"; do
  sleep 3
done

echo "✅ Banco de dados disponível!"

# Executa migrations de forma automática
echo "🚀 Executando migrations..."
php artisan migrate --force || echo "⚠️ Migrations já aplicadas. Continuando..."

# Gera cache de configuração
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🔥 Iniciando supervisor (Nginx + PHP-FPM)..."
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
