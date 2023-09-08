# User CRUD Symfony
CRUD API for the user entity

## Task description
Create the CRUD API for the employee entity.

### The entity must contain:
- First Name
- Last Name
- Email
- First day work
- Salary
- CreatedAt
- UpdateUt

### Validation
- first name, last name, email, first day of work, salary | Not null
- first day of work | Not past
- salary | Greater or equal to 100


## Stack
- PHP 8.2
- Symfony 6
- NelmioApiDocBundle
- Doctrine
- Postgresql
- UnitTest
- Docker/docker-compose
- Git
- CS-Fixer

## Project structure
```
.
├── bin
├── config
├── docker
│   ├── nginx
│   │   ├── default.conf
│   │   ├── Dockerfile
│   │   └── nginx.conf
│   └── php-fpm
│       └── Dockerfile
│
├── migrations
├── public
├── src
│   ├── Attribute
│   ├── Controller
│   ├── DTO
│   ├── Entity
│   ├── EventListener
│   ├── Exception
│   ├── Repository
│   ├── Service
│   ├── ValueResolver
│   └── ...
├── templates
├── test
│   ├── Controller
│   ├── Service
│   └── ...
├── docker-compose.yml
├── README.md
└── ...
```

## The Fast Track
1 Copy and run in the terminal
```
git clone https://github.com/BlackSou/user-crud-symfony.git app
```
2 Run Docker containers(wait few minutes)
```
docker-compose build
```
```
docker-compose up -d
```
3 Open the Docker PHP container
```
docker exec -ti php-fpm sh
```
4 Install Composer dependencies
```
composer install
```
5 Run migrations
```
php bin/console doctrine:migrations:migrate
```

## API Endpoints
http://127.0.0.1:88/api/doc

#### Other commands
PHP-CS-Fixer
```
./vendor/bin/php-cs-fixer fix --dry-run --diff
```
```
./vendor/bin/php-cs-fixer fix
```
PHPUnit
```
php bin/phpunit
```


