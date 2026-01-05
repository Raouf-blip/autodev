# Vitest

## Lien des TD 
https://github.com/ChristopheSauder/cours-3-exercice

## Introduction à Vitest
Vitest est un framework de test de nouvelle génération basé sur Vite. Il s’utilise de la même manière que le framework Jest. Bien qu’il soit spécialement conçu pour Vite, Vitest peut également fonctionner de façon indépendante.

## Installation
Pour installer Vitest, utilisez la commande suivante :  
```bash
npm install vitest --save-dev
```
Une fois Vite installé, vous pouvez créer un fichier de configuration à la racine du projet nommé `vitest.config.js`.

Pour lancer vos tests, utilisez la commande :  
```bash
npm run test
```

## Les fichiers de test
Il y a plusieurs façons de nommer les tests :

- Dans un dossier `test` à la racine de votre application, avec le suffixe `.test.js` (ex. `router.test.js`)
- Ou directement dans le code source, dans un dossier `__test__`, avec des fichiers nommés `*.spec.js` (ex. dans le dossier `router`, ajouter un sous-dossier `__test__` contenant `router.spec.js`)

Par défaut, en créant un projet avec le CLI [create-vite](https://www.npmjs.com/package/create-vite), c’est la deuxième méthode qui est utilisée.

## Écriture des tests
Comme mentionné dans l’introduction, Vitest se base sur Jest, et utilise donc la même syntaxe. Voici un exemple :  

```js
import { assert, describe, expect, it } from 'vitest'

describe('Math test', () => {
  it('should do square root', () => {
    assert.equal(Math.sqrt(4), 2)
  })

  it('should add numbers', () => {
    expect(1 + 1).eq(2)
  })
})
```

La fonction `describe()` permet de grouper plusieurs tests, tandis que `it()` (ou `test()`) définit un test individuel, favorisant une lecture fluide.  
Pour faire des assertions, vous pouvez utiliser `assert()` (fonctionne comme en PHPUnit) ou `expect()`, qui prend en argument le résultat et permet d’enchaîner des méthodes pour confirmer le comportement attendu.

## Interface utilisateur (UI)
Utilisant le même système que Vite, Vitest propose également un serveur de développement lors de l’exécution des tests. Cela permet d’accéder à une interface graphique pour visualiser et interagir avec les résultats de tests.  
Pour l’installer :  
```bash
npm i -D @vitest/ui
```

Et pour lancer l’interface :  
```bash
vitest --ui
```

## Conclusion
1. **Basé sur Jest**  
   Vitest s’appuie sur Jest, framework très populaire en JavaScript. Cela assure une grande ressource communautaire, une base solide et une migration facilitée.

2. **Rapidité d’exécution**  
   Vitest est conçu pour être très rapide, ce qui accélère le cycle de développement.

3. **Lisibilité**  
   Sa syntaxe simple facilite la création, la compréhension et la maintenance des tests.

4. **Flexibilité**  
   Vitest peut être utilisé pour tester une large gamme d’applications JavaScript, côté client ou serveur.