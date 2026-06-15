FROM dunglas/frankenphp:1-php8.4

# Copiar o Composer da imagem oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar Node.js e NPM para compilar os assets (Vite)
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP necessárias para o Laravel e SQLite
RUN install-php-extensions pcntl zip bcmath gd intl pdo_sqlite

# Remover capacidades (capabilities) do binário do FrankenPHP para permitir execução no ambiente restrito do Render
RUN apt-get update && apt-get install -y libcap2-bin && setcap -r /usr/local/bin/frankenphp

WORKDIR /app

# Copiar os arquivos do projeto
COPY . /app

# Instalar dependências PHP (incluindo dev para o Faker poder rodar os seeders) e compilar o front-end (Vite)
RUN composer install --optimize-autoloader --no-interaction
RUN npm install && npm run build

# Criar arquivo .env e gerar a chave de criptografia (APP_KEY)
RUN cp .env.example .env && php artisan key:generate

# Garantir o banco SQLite, rodar as migrations e os seeders durante o build
RUN touch database/database.sqlite && php artisan migrate --force && php artisan db:seed --force

# Criar o link simbólico da pasta de arquivos (storage)
RUN php artisan storage:link

# Configurar permissões para o Laravel (inclusive a pasta database e public/storage para gravação)
RUN chmod -R 777 storage bootstrap/cache database public/storage


# Definir o SERVER_NAME para escutar na porta 10000 em HTTP simples (sem SSL automático do Caddy)
ENV SERVER_NAME="http://:10000"

# Porta padrão que o Render utiliza
ENV PORT=10000
EXPOSE 10000

# Cachear configurações e iniciar o servidor usando o Caddyfile oficial do FrankenPHP
CMD php artisan config:cache && php artisan route:cache && php artisan view:cache && frankenphp run --config /etc/caddy/Caddyfile



