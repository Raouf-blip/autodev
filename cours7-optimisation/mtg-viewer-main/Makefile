install:
	@printf "Installing the program...\n"
	@cp .env.example .env
	@docker compose pull
	@docker compose build
	@docker compose run --rm php composer install
	@docker compose run --rm vite npm install
	@docker compose run --rm --remove-orphans php bin/console doctrine:migrations:migrate --no-interaction

get-data:
	@printf "Downloading the data from the source...\n"
	@curl https://mtgjson.com/api/v5/AllPrintingsCSVFiles.zip -o data/AllPrintingsCSVFiles.zip
	@unzip -o data/AllPrintingsCSVFiles.zip -d data

lint:
	@printf "Linting the code..."
	@docker compose run --rm php composer run-script phpcs
	@docker compose run --rm php composer run-script phpstan
	@docker compose run --rm vite npm run lint

lint\:fix:
	@printf "Linting the code..."
	@docker compose run --rm php composer run-script phpcs:fix
	@docker compose run --rm php composer run-script phpstan
	@docker compose run --rm vite npm run lint:fix
