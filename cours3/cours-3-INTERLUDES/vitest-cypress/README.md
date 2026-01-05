# TP Automatisation du developpement - Test - Vitest / Cypress

Exercice pour le cours d'automatisation du développement sur les tests.

Ce projet contient une application Vue + Vite.

Il y a deux page pour ce projet :

- `Home` : Accueil de l'application
- `Demo` : Contient un counter et un champs texte

## Installation

```sh
docker compose run --rm node npm install
```

### Compile and Hot-Reload for Development

```sh
docker compose run --rm node npm run dev
```

### Compile and Minify for Production

```sh
docker compose run --rm node npm run build
```

### Run Unit Tests with [Vitest](https://vitest.dev/)

```sh
docker compose run --rm node npm run test
```

### Run Unit Tests with [Vitest](https://vitest.dev/) and [Istanbul](https://istanbul.js.org/) for coverage

```sh
docker compose run --rm node npm run test:coverage
```

### Run Unit Tests with [Vitest UI](https://vitest.dev/guide/ui.html)

```sh
docker compose run --rm node npm run test:ui
```

### [DEPERACTED] Run End-to-End Tests with [Cypress](https://www.cypress.io/)

```sh
docker compose run --rm node npm run test:e2e:dev
```

This runs the end-to-end tests against the Vite development server.
It is much faster than the production build.

But it's still recommended to test the production build with `test:e2e` before deploying (e.g. in CI environments):

```sh
docker compose run --rm node npm run build
docker compose run --rm node npm run test:e2e
```

### Lint with [ESLint](https://eslint.org/)

```sh
docker compose run --rm node npm run lint
```

### Format with [Prettier](https://prettier.io/)

```sh
docker compose run --rm node npm run format
```

## Structure du projet

- **cypress**: Dossier contenant les tests End-To-End
  - **e2e** : Fichier de test
  - **fixture** : Dossier contenant les dataFixtures pour les test
  - **support** : Configuration de commande global pour cypress
- **src** : Contient le code source de l'application
  - **assets** : image et css de base pour l'application
  - **component** : Composants Vue
    - **\_\_test\_\_** : Dossier contenant les tests pour les composants
  - **router** : Configuration du router
  - **store** : Définition des stores
    - **\_\_test\_\_** : Dossier contenant les tests pour le store
  - **views** : Dossier contenant les pages de l'application
- **coverage** : Dossier contentant les rapports de test coverage

## Attendu

1. ### Test des composants

   - Ecrire les tests pour les composants `Counter` et `InputText`

2. ### Test du Router

   - Ecrire les tests pour vérifier que le router navigue bien sur les bonnes pages.

3. ### Test du Store

   - Ecrire les tests pour vérifier que les methodes du store sont corrects

4. ### [DEPRECATED] Test End-To-End Cypress

   - Ecrire au moins un sénario End-To-End en utilisant Cypress. Le sénario doit correspondre au comportement probable d'un utilisateur et tester le bon déroulement.
