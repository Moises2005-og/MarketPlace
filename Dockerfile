FROM dunglas/frankenphp:1-php8.3

# Copiar o Composer da imagem oficial
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Instalar Node.js e NPM para compilar os assets (Vite)
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensões PHP necessárias para o Laravel e SQLite
RUN install-php-extensions pcntl zip bcmath gd intl pdo_sqlite

WORKDIR /app

# Copiar os arquivos do projeto
COPY . /app

# Configurar permissões para o Laravel
RUN chmod -R 777 storage bootstrap/cache

# Instalar dependências PHP e compilar o front-end (Vite)
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm install && npm run build

# Definir a pasta pública como raiz do servidor web
ENV FRANKENPHP_DOCUMENT_ROOT=/app/public

# Porta padrão que o Render utiliza
ENV PORT=10000
EXPOSE 10000

# Cachear configurações e iniciar o servidor web do FrankenPHP
CMD php artisan config:cache && php artisan route:cache && php artisan view:cache && frankenphp php-server --listen :10000
