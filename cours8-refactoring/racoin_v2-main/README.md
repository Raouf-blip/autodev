## Racoin

Racoin est une application de vente en ligne entre particuliers.

## Installation
Les commandes suivantes permettent d'installer les dépendances et de construire les fichiers statiques nécessaires au bon fonctionnement de l'application.
```bash
cp config/config.ini.dist config/config.ini
docker compose up -d
docker compose run --rm php composer install
docker compose run --rm php php sql/initdb.php
docker compose run node npm install
docker compose run node npm run build
```

## Utilisation
Pour lancer l'application, il suffit de lancer la commande suivante:
```bash
docker compose up -d
```
accès : localhost:8080

## Tests
```bash
docker compose run --rm php composer test
```

## Documentation API (Swagger)
Générer la documentation OpenAPI :
```bash
docker compose run --rm php composer swagger
```
Le fichier `public/openapi.json` est généré. Vous pouvez le visualiser sur https://editor.swagger.io/

## Architecture

```
src/
├── Controller/         # Contrôleurs (HomeController, AnnonceController, etc.)
├── Database/           # Connexion base de données
├── Middleware/          # Middlewares Slim (logs, trailing slash)
└── Model/              # Modèles Eloquent (Annonce, Annonceur, etc.)
template/               # Vues Twig
public/                 # Point d'entrée web
logs/                   # Fichiers de logs
tests/                  # Tests PHPUnit
```

## Stack technique
- PHP 8.2+
- Slim 4 (framework HTTP)
- Twig 3 (templating)
- Eloquent ORM (illuminate/database)
- Monolog (logging)
- Swagger/OpenAPI (documentation API)
- PHPUnit (tests)
