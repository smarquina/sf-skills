.PHONY: \
	build \
	deps \
	start \
	stop \
	down \
	run \
	composer-install \


include .env.docker
export $(shell sed 's/=.*//' .env.docker)

build: deps install-app #composer-install
deps: create-networks create-volumes

start: CMD=up -d
stop: CMD=stop
down: CMD=down

install-app:
	docker-compose build --pull
#--no-cache

run:
	docker-compose up -d

down:
	docker-compose down -v --remove-orphans --rmi local

create-volumes:
	@docker volume create skills_mysql

create-networks:
	@(docker network create sf-skills-network > /dev/null 2>&1 && echo "network sf-skills-network created") || echo "network sf-skills-network exists"

composer-install:
	docker-compose run --rm composer install --no-interaction
	docker-compose run composer dump-autoload --optimize
