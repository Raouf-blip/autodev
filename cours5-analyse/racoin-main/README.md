# Racoin

Site de petites annonces (clone simplifié type Le Bon Coin), développé en PHP.

## Stack technique

| Composant | Version |
|---|---|
| PHP | 8.2 |
| Slim Framework | 4.x |
| Twig | 3.x |
| Illuminate/Database (Eloquent) | 10.x |
| MySQL | 5.7 |

## Prérequis

- Docker & Docker Compose

## Démarrage rapide

```bash
# 1. Cloner le dépôt
git clone <url-du-repo> racoin
cd racoin

# 2. Créer le fichier de configuration BDD
cp config/config.ini.example config/config.ini

# 3. Lancer les conteneurs (PHP + MySQL + phpMyAdmin)
docker-compose up -d

# 4. Installer les dépendances Composer
docker-compose exec php composer install

# 5. Accéder à l'application
# App        → http://localhost:8080
# phpMyAdmin → http://localhost:8081
```

La base de données est initialisée automatiquement au premier démarrage
grâce aux fichiers montés dans `/docker-entrypoint-initdb.d/`.

## Structure du projet

```
.
├── config/               Configuration BDD (config.ini)
├── controller/           Contrôleurs (logique métier)
├── db/                   Connexion Eloquent
├── docker/php/           Dockerfile PHP
├── model/                Modèles Eloquent
├── sql/                  Schéma + données de test
├── template/             Templates Twig
├── stylesheets/          CSS compilé depuis SCSS
├── js/                   Scripts JavaScript
├── img/                  Images statiques
├── index.php             Point d'entrée (Slim 4)
└── composer.json         Dépendances PHP
```

## Fonctionnalités

- Consultation des dernières annonces (accueil)
- Navigation par catégorie
- Recherche (mots-clés, ville, catégorie, prix)
- Dépôt d'annonce (protégée par mot de passe)
- Modification / suppression d'annonce
- Profil annonceur
- API REST (annonces, catégories)
- Générateur de clés API

## API REST

| Méthode | URL | Description |
|---|---|---|
| GET | `/api/annonces` | Liste de toutes les annonces |
| GET | `/api/annonce/{id}` | Détail d'une annonce |
| GET | `/api/categories` | Liste des catégories |
| GET | `/api/categorie/{id}` | Annonces d'une catégorie |
| GET/POST | `/api/key` | Génération de clé API |
