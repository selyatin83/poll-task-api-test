# XIAG Poll task API

## Install

1. Install "cmake" to run the commands. If you don`t want to do it, then see the commands in /Makefile. 
</br> <a href='https://cmake.org/'>About Cmake</a> 
2. Init environments, use the following command:
```
1. Cmake: make init-local
2. Without Cmake: cp -n ./envs/.env.local ./.env;
```
3. To start containers, use the following command:
```
1. Cmake: make up
2. Without Cmake: docker-compose up --build -d
```
4. Run composer install, use the following command:
```
1. Cmake: make composer-install
2. Without Cmake: docker-compose run --rm --no-deps fpm composer install
```
5. To run the migrations, use the following command:
```
1. Cmake: make migration-up
2. Without Cmake: docker-compose run --rm --no-deps fpm ./vendor/bin/phinx migrate
```
6. Ready! API is available at http://127.0.0.1:8010
7. API Documentation: Swagger is available at http://127.0.0.1:8010/swagger/

## Tests

1. To start API test run following the command:
```
1. CMake: make run-api-tests
2. Without Cmake: docker-compose run --rm --no-deps fpm php vendor/bin/codecept run api
```
You need to run the tests after full clear database:
```
1. Drop tables
2. Run migrations
3. Run tests
```