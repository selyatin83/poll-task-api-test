ARGS=$(filter-out $@, $(MAKECMDGOALS))

init-local:
	cp -n ./envs/.env.local ./.env;

up:
	docker-compose up -d

down:
	docker-compose down

shell-fpm:
	docker exec -it php-fpm bash

run-api-tests:
	docker-compose run --rm --no-deps fpm php vendor/bin/codecept run api

composer-install:
	docker-compose run --rm --no-deps fpm composer install

composer-update:
	docker-compose run --rm --no-deps fpm composer update ${ARGS}

composer-require:
	docker-compose run --rm --no-deps fpm composer require ${ARGS}

composer-remove:
	docker-compose run --rm --no-deps fpm composer remove ${ARGS}

migration-create:
	docker-compose run --rm --no-deps fpm ./vendor/bin/phinx create ${ARGS}

migration-up:
	docker-compose run --rm --no-deps fpm ./vendor/bin/phinx migrate

migration-rollback:
	docker-compose run --rm --no-deps fpm ./vendor/bin/phinx rollback ${ARGS}

%:
	@true
