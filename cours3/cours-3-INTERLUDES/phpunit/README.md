# TP Automatisation du developpement - Test - PHPUnit

Exercice pour le cours d'automatisation du développement sur les tests.

Ce projet contient une classe `Calculator.php` qui permet de faire des opérations basique

## Technologie utilisées

- PHP 8.2
- PHPUnit 10.5

## Installation

```sh
docker compose run --rm php composer install
```

## Script

### Run test with [PHPUnit](https://phpunit.de/)

```sh
docker compose run --rm php composer test
```

utilise la configuration disponible dans le fichier `phpunit.xml`

### Run test and coverage

```sh
docker compose run --rm php composer test:coverage
```

édite un rapport au format HTML dans le dossier `coverage`

### Linter

```sh
docker compose run --rm php composer phpcs
```

```sh
docker compose run --rm php composer phpcs:fix
```

### PHPStan

```sh
docker compose run --rm php composer phpstan
```

## Structure du projet

- **src** : Contient le code source de l'application
- **tests** : Contient le code source des tests
- **coverage** : Dossier contentant les rapports de test coverage

## Attendu

Vous devrez écrire les tests pour couvrir toutes les fonctions de la classe Calculator.php et afficher un rapport de code coverage à 100%. Un exercice plus complet sera vu en TD.

### Tips

Servez vous des rapports de code coverage pour vérifier la pertinence de vos tests.

Si vous rencontrer l'erreur :
  > No code coverage driver available

C'est que vous n'avez pas l'extention XDebug de configuré avec PHP. Pour l'ajouter suivez le [guide d'installation](https://xdebug.org/docs/install) pour votre OS.
