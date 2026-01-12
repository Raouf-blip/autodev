# Immo API PHP

API REST pour la gestion immobilière avec Slim 4 et MySQL.

## Prérequis

- Docker et Docker Compose

## Installation

1. Créer le fichier `.env` :
```env
MYSQL_HOST=mysql
MYSQL_DATABASE=immo_db
MYSQL_USER=user
MYSQL_PASSWORD=password
```

2. Lancer les conteneurs :
```bash
docker compose up -d --build
```

3. Tester : http://localhost:8080 → `{"message":"Hello World!"}`

## Commandes utiles

```bash
docker compose up -d          # Démarrer
docker compose down           # Arrêter
docker compose logs -f        # Logs
docker compose exec php bash  # Shell dans le conteneur
```
