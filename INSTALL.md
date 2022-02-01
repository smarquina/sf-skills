# Symfony Skills

This project is build on top of [Symfony 6](https://symfony.com/doc/6.0/index.html), 
[MySQL 8.0](https://dev.mysql.com/doc/refman/8.0/en/) and
dockerized with [Docker compose](https://docs.docker.com/compose/).

Install steps are the following:
* Download the [repo](https://github.com/smarquina/sf-skills)
* Make sure you have Docker / Docker-compose installed in your system
* Run `$ make build` to build the images and download vendor
* Run `$ make run` to up all containers

🐳 All containers are running now 🐳

If this is a clean install, you must previously create DB schema and tables. Follow next steps:
* Go to project folder in the terminal
* Run `$ docker-compose exec php /bin/bash` to jump into PHP container
* Run `$ php bin/console doctrine:migrations:migrate` to create tables

That's all!! go to `http://localhost:8001` in your browser and enjoy!

---------------------------

##Additional info

Environment variables can be customized. Project vars are located under `.env.docker` file.
Following vars can be modified:
* DB_USERNAME: DB username (default: symfony)
* DB_PASSWORD: DB password (default: skills)
* FORWARD_DB_PORT: DB port (default: 3306)
* DB_DATABASE: DB schema name (default: sf_skills)
* HTTP_PORT: application entrypoint port (default: 8001)
* TIMEZONE application default timezone (default: Europe/Madrid)



