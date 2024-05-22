php-image-name     :=php

build:
	docker-compose build

up:
	docker-compose up -d
	make apache-stop

down:
	docker-compose down

php-artisan: ## run a command cmd="landers:sync -v" for egp
ifdef cmd
	docker compose exec $(php-image-name) php artisan $(cmd)
else
	@echo "Please specify a cmd to run, e.g make console cmd='landers:sync -v'"
endif

composer: ## run a command cmd="landers:sync -v" for egp
ifdef cmd
	docker compose exec $(php-image-name) composer $(cmd)
else
	@echo "Please specify a cmd to run, e.g make console cmd='landers:sync -v'"
endif

dump-autoload:
	docker compose exec php composer dump-autoload

artisan-clear:
	make php-artisan cmd="cache:clear"
	make php-artisan cmd="route:clear"

migrate-up:
	docker compose exec $(php-image-name) php artisan migrate

migrate-down:
	docker compose exec $(php-image-name) php artisan migrate:rollback

migrate-create:
ifdef name
	docker compose exec $(php-image-name) php artisan make:migration $(name)
else
	@echo "Please specify a cmd to run, e.g make console name='create_x_table'"
endif

db-seed:
	docker compose exec $(php-image-name) php artisan db:seed

apache-stop:
	sudo /etc/init.d/apache2 stop
