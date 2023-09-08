# user-crud-symfony
CRUD API for the user entity

git clone https://github.com/BlackSou/user-crud-symfony.git
docker-compose build
docker-compose up -d

docker exec -ti php-fpm sh
composer install

DB
php bin/console make:migration
php bin/console doctrine:migrations:migrate

PHP-CS-Fixer
./vendor/bin/php-cs-fixer fix --dry-run --diff
./vendor/bin/php-cs-fixer fix

PHPUnit
php bin/phpunit

http://127.0.0.1:88/api/doc
