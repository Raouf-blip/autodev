# PHP Unit

## Introduction
[Lien vers la documentation](https://phpunit.de/)  

PHPUnit est un framework de tests unitaires pour PHP. Il permet de tester le code PHP de manière automatisée afin de garantir la qualité du logiciel.

Les tests unitaires consistent à vérifier que chaque partie isolée d’un programme fonctionne correctement. PHPUnit facilite la création, l’exécution et l’analyse de ces tests.

## Installation
Comme pour toute librairie PHP, le plus simple est de l’installer via Composer :  
```bash
composer require --dev phpunit/phpunit
```
⚠️ L’option `--dev` installe le package dans la section `require-dev`. La commande `composer install --no-dev` permet de ne pas installer les packages de cette section (linters, faker, tests, générateurs de documentation, etc.).

## Utilisation
Après installation, lancez les tests avec la commande suivante :  
```bash
./vendor/bin/phpunit
```
Cette commande utilise le fichier de configuration `phpunit.xml`. Il est fortement recommandé de privilégier ce fichier plutôt que les options en ligne de commande pour une meilleure lisibilité et modification facilitée.

Exemple de retour sans erreur :  

![success](https://i.ibb.co/KLLqSvL/success-phpunit.png)

Exemple en cas d’erreur :  

![error](https://i.ibb.co/84cyfZW/error-phpunit.png)

## Structure des Tests
Une bonne organisation des tests est cruciale pour maintenir un code lisible et évolutif. Voici quelques bonnes pratiques :  

- Répertoire des tests : placer dans un dossier dédié, par exemple `tests/`  
- Namespace : respecter la structure du namespace de la classe testée (ex. si la classe est dans `App\`, les tests iront dans `tests\App\`)  
- Nom des fichiers : suffixer par `Test` (ex. `CalculatriceTest.php`)  
- Organisation des classes : logique, par exemple `CalculatriceTest` pour tester la classe `Calculatrice`  
- Nom des méthodes : clair et explicite, ex. `testDivision()`, `testDivisionParZero()`  

Exemple d’arborescence :  
```plaintext
project/
│
├── src/
│   ├── Service/
│   │   └── UserService.php
│   │
│   ├── Model/
│   │   └── UserModel.php
│   │
│   └── Util/
│       └── Helper.php
│
├── tests/
│   ├── Service/
│   │   └── UserServiceTest.php
│   │
│   ├── Model/
│   │   └── UserModelTest.php
│   │
│   └── Util/
│       └── HelperTest.php
└── ...
```

## Les Assertions
PHPUnit propose de nombreuses méthodes d’assertion pour valider les résultats attendus. En voici quelques-unes courantes :  

- `assertTrue($condition)` : vérifie que la condition est vraie  
- `assertFalse($condition)` : vérifie que la condition est fausse  
- `assertEquals($expected, $actual)` : vérifie que les deux valeurs sont égales  
- `assertNotEmpty($value)` : vérifie que la valeur n’est pas vide  

[Voir la liste complète](https://docs.phpunit.de/en/10.5/assertions.html)

## Configuration de PHPUnit
Le fichier `phpunit.xml` configure PHPUnit : répertoires de tests,fichiers de bootstrap, variables d’environnement, etc.  

Exemple de fichier `phpunit.xml` :  
```xml
<?xml version="1.0" encoding="UTF-8"?>
<!-- Configuration de base -->
<phpunit 
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:noNamespaceSchemaLocation="./vendor/phpunit/phpunit/phpunit.xsd"
    bootstrap="vendor/autoload.php"
    colors="true">

  <!-- Configuration des répertoires de tests -->
  <testsuites>
      <testsuite name="Unit">
        <directory suffix="Test.php">./tests/Unit</directory>
      </testsuite>
      <testsuite name="Feature">
        <directory suffix="Test.php">./tests/Feature</directory>
      </testsuite>
  </testsuites>

  <!-- Configuration des répertoires de sources -->
  <source>
      <include>
        <directory suffix=".php">./app</directory>
      </include>
  </source>

  <!-- Variables d’environnement -->
  <php>
      <env name="APP_ENV" value="testing"/>
      <env name="XDEBUG_MODE" value="coverage" />
  </php>
</phpunit>
```

## Coverage
Pour générer un rapport de code coverage, lancez la commande de test avec l’option `--coverage-html` (pour un rapport en HTML).  

Pour que cela fonctionne, vous devez disposer de l’extension XDebug installée et activée dans PHP. ([Installation XDebug](https://xdebug.org/docs/install))

Il faudra aussi définir la variable d’environnement :  
```bash
export XDEBUG_MODE=coverage
```