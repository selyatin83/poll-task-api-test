ARGS=$(filter-out $@, $(MAKECMDGOALS))

init-local:
	cp -n ./envs/.env.local ./.env;

up:
	docker-compose up -d

down:
	docker-compose down

composer-install:
	docker-compose run --rm --no-deps php-fpm composer install

composer-update:
	docker-compose run --rm --no-deps php-fpm composer update ${ARGS}

composer-require:
	docker-compose run --rm --no-deps php-fpm composer require ${ARGS}

composer-remove:
	docker-compose run --rm --no-deps php-fpm composer remove ${ARGS}

%:
	@true
