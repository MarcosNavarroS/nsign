USER = $(shell id -u):$(shell id -g)
APP_ENV = local
PROJECT_NAME = nsign
COMPOSE = USER=${USER} docker-compose -p $(PROJECT_NAME) -f docker/docker-compose.yml
FPM_CONTAINER_NAME = nsign_php_fpm

.PHONY: tests

prepare: build up vendor-install

build:
	DOCKER_BUILDKIT=1 $(COMPOSE) build --no-cache --pull

vendor-install:
	@docker exec -it $(FPM_CONTAINER_NAME) composer install

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

bash:
	@docker exec -it $(FPM_CONTAINER_NAME) bash

tests:
	@docker exec -it $(FPM_CONTAINER_NAME) php bin/phpunit

swagger:
	@$(COMPOSE) up -d swagger-ui