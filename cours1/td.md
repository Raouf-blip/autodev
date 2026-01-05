# Automatisation du développement : Cours 1 - Exercice
## Préalable
Appliquer les principes de gitflow pour ces 3 projets.  
Chaque modification doit être faite via une branche `feature/*` et doit être mergée sur la branche `develop` (ou main) via une pull request.

Utiliser les principes gitflow pour ce projet, nommer correctement vos branches et vos commits.
Vous devez faire fonctionner les projets via un docker compose.
Rédiger un README.md pour chaque projet, qui permet d'expliquer sommairement le projet et de détailler son installation et sa méthodologie pour le mettre en route.

## Exercice PHP
Commencer par le projet PHP qui est plus détaillé et plus long :
- [ ] Installer et lancer le projet (le site doit afficher "Hello World", c'est tout) :
    - [ ] Créer un dockerfile pour php (et eventuellement nginx / apache)
    - [ ] Créer un fichier docker-compose.yml pour orchester et démarer les containers nécessaires => Vous devez avoir à minima une image docker pour la bdd, et une pour le serveur php
    - [ ] Créer un fichier .env 
- [ ] Importez les dépendances déja dans le projet grâce à composer
- [ ] Il manquera une dépendance (erreur php), l'importer grâce à composer
- [ ] Completer le readme
- [ ] Pusher vos modifications

## Exercices JS
même consigne pour les repos JS :
- [ ] Installer et lancer le projet. Le site doit s'afficher
    - [ ] Créer un fichier docker-compose.yml pour le serveur node dans lequel on executera les commandes NPM
    - [ ] Démarrer le container, installer les dépendances, démarrer le serveur ('npm run dev')
- [ ] Completer le readme
- [ ] Pusher vos modifications

### Rendre les exercices
Par groupe de 2 ou 3.
Vous trouverez sur Arche un endroit où déposer un fichier contenant le lien de votre repo GIT auquel je devrai avoir accès (ou m'envoyer par mail) ! Précisez-moi qui est dans le groupe.