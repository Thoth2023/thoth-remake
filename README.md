
# Thoth 2.0
[![Latest Stable Version](https://badgen.net/packagist/lang/monolog/monolog)](https://badgen.net/packagist/lang/monolog/monolog)
[![PHP Version Require](https://badgen.net/badge/php/%3E8.1/green)](https://badgen.net/badge/php/%3E8.1/green)

Systematic Literature Review Tool

## Technologies and Tools
<img src="https://camo.githubusercontent.com/85b8858163097e34c31ef8eeda533e1fa18be0ec8ce58f494b6b5cedc2f27196/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f6c61726176656c2d2532334646324432302e7376673f7374796c653d666f722d7468652d6261646765266c6f676f3d6c61726176656c266c6f676f436f6c6f723d7768697465" /><img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" /><img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" /><img src="https://img.shields.io/badge/JavaScript-323330?style=for-the-badge&logo=javascript&logoColor=F7DF1E" /><img src="https://img.shields.io/badge/json-5E5C5C?style=for-the-badge&logo=json&logoColor=white" /><img src="https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D" /><img src="https://img.shields.io/badge/Docker-2CA5E0?style=for-the-badge&logo=docker&logoColor=white" /><img src="https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white" /><img src="https://img.shields.io/badge/Git-F05032?style=for-the-badge&logo=git&logoColor=white" /><img src="https://img.shields.io/badge/Chart.js-FF6384?style=for-the-badge&logo=chartdotjs&logoColor=white" /><img src="https://img.shields.io/badge/Webpack-8DD6F9?style=for-the-badge&logo=Webpack&logoColor=white" />

### Understanding the Framework Structure
1. Laravel DOC - https://laravel.com/docs/10.x
2. Understanding the structure - https://www.youtube.com/watch?v=zN0gAqOcxsk

### Suggested Bootstrap Template
Information on how to use the template elements
https://argon-dashboard-laravel.creative-tim.com/docs/bootstrap/overview/argon-dashboard/

## Step-by-Step Initial Setup

- Have Docker Desktop installed:
https://www.docker.com/products/docker-desktop/

- In your development IDE (PHP Storm, VSCode, or another of your preference)

Clone the Repository
```sh
git clone -b https://github.com/Thoth2023/thoth-remake.git
```
Create the .env File
```sh
cp .env.example .env
```
Start the Project Containers
```sh
docker-compose up -d
```
Access the App Container
```sh
docker-compose exec app bash
```
Install Project Dependencies
```sh
composer install
```
If there are any errors during dependency installation
```sh
composer update
```

Generate the Laravel Project Key
```sh
php artisan key:generate
```

To Populate the Database
```sh
php artisan migrate --seed
```
```sh
For development, create a new branch from "Develop"
```

## Access the Project
[http://localhost:8989](http://localhost:8989)



## Make Shortcuts
```bash
# Start Docker in the Background
up:
    docker-compose up -d

# Shut Down the Containers
down:
	docker-compose down

# Restart the Containers
restart:
	docker-compose restart

# Show Logs
logs:
	docker-compose logs -f

# Show Container Status and All Containers
ps:
	docker-compose ps -a

# Inside the Container, Install Composer Dependencies and Generate the Key (To access the container, use the command: docker-compose exec app bash)
setup:
	composer install || composer update
	php artisan key:generate
	php artisan migrate --seed
```

If needed, visit https://www.gnu.org/software/make/ for more details.

To use make:

- Access the project directory
- Open the terminal/console
- Type make (command)

Example: To list the containers, run

```bash
make ps 
```
To install the project dependencies, you can access the container with
```bash
docker-compose exec app bash
```
And inside the container, run
```bash
make setup
```

## Access the Project
[http://localhost:8989](http://localhost:8989)
