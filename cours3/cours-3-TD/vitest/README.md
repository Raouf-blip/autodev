# TP Automatisation du developpement - Test - Vitest / Cypress

Exercice pour le cours d'automatisation du développement sur les tests.

Ce projet contient une application Vue + Vite.

Il y a deux page pour ce projet :

- `Home` : Accueil de l'application
- `Demo` : Contient un counter et un champs texte

## Installation

Docker est utilisé pour simplifier l'installation des dépendances et l'exécution des commandes, mais ici il est facultatif
(si vous avez `node` et `npm` installés localement, vous pouvez exécuter les commandes directement mais ce n'est pas ce que je recommande)

### DOCKER :

```sh
docker compose run --rm node npm install
```

### Start container

```sh
docker compose up -d
```

### Compile and Hot-Reload for Development

```sh
docker compose run --rm node npm run test 
// ou si votre container tourne déja : 
docker compose exec node npm run dev
```

=> acces via http://localhost:3000

### Run Unit Tests with [Vitest](https://vitest.dev/)

```sh
docker compose run --rm node npm run test
// ou "exec" si votre container tourne déja
```

### Run Unit Tests with [Vitest](https://vitest.dev/) and [Istanbul](https://istanbul.js.org/) for coverage

```sh
docker compose run --rm node npm run test:coverage
// ou "exec" si votre container tourne déja
```

### Run Unit Tests with [Vitest UI](https://vitest.dev/guide/ui.html)

```sh
docker compose run --rm node npm run test:ui
// ou "exec" si votre container tourne déja
```

### (facultatif) Lint with [ESLint](https://eslint.org/)

```sh
docker compose run --rm node npm run lint
// ou "exec" si votre container tourne déja
```

### (facultatif) Format with [Prettier](https://prettier.io/)

```sh
docker compose run --rm node npm run format
// ou "exec" si votre container tourne déja
```

## Structure du projet

- **src** : Contient le code source de l'application
  - **assets** : image et css de base pour l'application
  - **component** : Composants Vue
    - **\_\_test\_\_** : Dossier contenant les tests pour les composants
  - **router** : Configuration du router
  - **store** : Définition des stores
    - **\_\_test\_\_** : Dossier contenant les tests pour le store
  - **views** : Dossier contenant les pages de l'application
- **coverage** : Dossier contentant les rapports de test coverage
