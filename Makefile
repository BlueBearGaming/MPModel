.PHONY: help
help: ## This help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(TARGETS) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

-include docker/.env
docker/.env:
	cp docker/.env.dist docker/.env
	$(MAKE) docker/.env

.PHONY: install
install: start ## Run docker instance and launch composer install
	cd docker && docker-compose exec www composer install

.PHONY: start
start: docker/.env ## Start docker
	cd docker && docker-compose up --build -d

.PHONY: stop
stop: ## Stop and destroy docker images
	cd docker && docker-compose down

.PHONY: shell
shell: start ## Start a shell
	cd docker && docker-compose exec www zsh

.PHONY: reset
reset:
#	cd docker && docker-compose exec www bin/console doctrine:schema:create
	cd docker && docker-compose exec www bin/console cleverage:process:execute initial.import.resources initial.import.climates
	cd docker && docker-compose exec www bin/console bluebear:generate:world
