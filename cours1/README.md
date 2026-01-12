# Temirov Abdoul-Raouf
# Blonbou Mathys


Lancer les containers:
docker-compose up --build -d

Note: Il manquera une dépendance (erreur php), l'importer grâce à composer:
docker compose exec php composer require lukasoppermann/http-status
composer update