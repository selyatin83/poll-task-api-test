ARGS=$(filter-out $@, $(MAKECMDGOALS))

init-local:
	cp -n ./environments/.env.local ./.env;

init-prod:
	cp -n ./environments/.env.prod ./.env;

init-demo:
	cp -n ./environments/.env.demo ./.env;

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
