
# Iniciar o docker no background
up:
	docker-compose up -d

# Desliga os containers
down:
	docker-compose down

# Reinicia os containers
restart:
	docker-compose restart

# Mostra logs
logs:
	docker-compose logs -f

# Mostra status dos containers e todos os containers
ps:
	docker-compose ps -a

# Dentro do container, instala as dependências do composer e gera a chave(Para acessar o container use o comando: docker-compose exec app bash)

setup:
	composer install || composer update
	php artisan key:generate
	php artisan migrate --seed




