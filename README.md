
# Thoth  2.0
[![Latest Stable Version](https://badgen.net/packagist/lang/monolog/monolog)](https://badgen.net/packagist/lang/monolog/monolog)
[![PHP Version Require](https://badgen.net/badge/php/%3E8.1/green)](https://badgen.net/badge/php/%3E8.1/green)

Ferramenta de Revisão Sistemática da Literatura

## Tecnologias e Ferramentas
<img src="https://camo.githubusercontent.com/85b8858163097e34c31ef8eeda533e1fa18be0ec8ce58f494b6b5cedc2f27196/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f6c61726176656c2d2532334646324432302e7376673f7374796c653d666f722d7468652d6261646765266c6f676f3d6c61726176656c266c6f676f436f6c6f723d7768697465" /><img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" /><img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" /><img src="https://img.shields.io/badge/JavaScript-323330?style=for-the-badge&logo=javascript&logoColor=F7DF1E" /><img src="https://img.shields.io/badge/json-5E5C5C?style=for-the-badge&logo=json&logoColor=white" /><img src="https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D" /><img src="https://img.shields.io/badge/Docker-2CA5E0?style=for-the-badge&logo=docker&logoColor=white" /><img src="https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white" /><img src="https://img.shields.io/badge/Git-F05032?style=for-the-badge&logo=git&logoColor=white" /><img src="https://img.shields.io/badge/Chart.js-FF6384?style=for-the-badge&logo=chartdotjs&logoColor=white" /><img src="https://img.shields.io/badge/Webpack-8DD6F9?style=for-the-badge&logo=Webpack&logoColor=white" />

### Entendendo a Estrutura do framework
1. Laravel DOC - https://laravel.com/docs/10.x
2. Entendendo a estrutura - https://www.youtube.com/watch?v=zN0gAqOcxsk

### Template Bootstrap Sugerido
Informações de como usar os elementos do template
https://argon-dashboard-laravel.creative-tim.com/docs/bootstrap/overview/argon-dashboard/


## Passo a passo para Configuração inicial

-Ter o Docker Desktop instalado:
https://www.docker.com/products/docker-desktop/

- Na sua IDE de desenvolvimento (PHP Storm, VSCode ou outra de sua preferência)

Clone Repositório 
```sh
git clone -b https://github.com/Thoth2023/thoth-remake.git
```
Crie o Arquivo .env
```sh
cp .env.example .env
```
Suba os containers do projeto
```sh
docker-compose up -d
```
Acesse o container app
```sh
docker-compose exec app bash
```
Instale as dependências do projeto
```sh
composer install
```
Se der algum erro na instalação das dependências
```sh
composer update
```

Gere a key do projeto Laravel
```sh
php artisan key:generate
```

Para popular o Banco de Dados
```sh
php artisan migrate --seed
```
```sh
Para desenvolvimento, crie uma nova branche a partir de "Develop"
```



## Atalhos com Make
```bash
#Iniciar o Docker em segundo plano
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
```

Se preciso, acesse https://www.gnu.org/software/make/ para mais detalhes

Para utilizar o make: 
1. Acesse o diretório do projeto
2. Abra o terminal/console
3. Digite make (comando)

Exemplo: Para listar os containers  execute 

```bash
make ps 
```
Para instalar as dependências do projeto você pode acessar o container com 
```bash
docker-compose exec app bash
```
E dentro do container execute
```bash
make setup
```

## Acesse o projeto
[http://localhost:8989](http://localhost:8989)
