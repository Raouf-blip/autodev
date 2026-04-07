# Maintenance Applicative
## Exercice Cours 7+8 - Optimisation/Refactoring

### Préambule
README.md pour installer l’application

**APRÈS CHAQUE ÉTAPE : Rejouez les tests pour vous assurer que tout fonctionne toujours correctement**

### 1 - Mise en place des tests
Avant de passer à la refactorisation, écrivez quelques tests fonctionnels pour vous assurer que tout fonctionne correctement. Je vous conseille de tester les routes principales de l’application (ex: accès à l'accueil, consultation d'une annonce, création d'une annonce); Vous aurez besoin d'installer les packages nécessaires.
Gardez en tete que (à part suite à la mise à jour de slim) il ne faudra pas modifier les tests pour les faire passer après la refactorisation, donc essayez de les écrire de manière à ce qu'ils soient le moins couplés possible à l'implémentation du code.

### 2 - Architecture
Pour commencer, essayez de retravailler l’architecture de l’application afin d’en améliorer la compréhension générale : renommez les fichiers pour plus de lisibilité et découpez-les différemment si nécessaire. Organisez le code de manière claire et cohérente, sans toucher le contenu des fonctions ou des classes (sauf pour les changements nécessaires à la nouvelle organisation).

### 3 - Mise à jour de Slim
- Passez à Slim 4 et faire toutes les [corrections nécessaires](https://www.slimframework.com/docs/v4/start/upgrade.html) pour que le code fonctionne avec cette nouvelle version. Mettez à jour les autres packages si nécessaire. Vous aurez besoin de la dépendance PSR7 également.
- Pour cette question , vous devrez modifier les classes de tests afin qu'elles soient compatibles avec la nouvelle version de Slim.
Le site et les tests doivent continuer à fonctionner après la mise à jour. C'est la question la plus longue, si vous avez des blocages, n'hésitez pas à me demander de l'aide.

### 4 - Amélioration du code
Mettez le code aux derniers standards de PHP 8 (typage des arguments et retours de fonctions, typage des proprietés de classe, utilisation de nullsafe, promotion des proprietés du constructeur, etc.).

### 5 - Refactorisation
Essayez d’améliorer au maximum le code actuel sans modifier le fonctionnement de l’application : meilleur nommage des variables, factorisation, simplification des conditions, boucles, indentation, commentaires, etc.

### 6 - Ajout de logs
https://www.slimframework.com/docs/v4/middleware/error-handling.html#error-logging
- Ajoutez des logs au level approprié, pour chaque requête HTTP, avec Monolog
- Utiliser le middleware de Slim pour logger également les erreurs => lorsque vous accedez à la route /exception, une exception est levée, et vous devriez voir le message d'erreur dans les logs.

### 7 - Ajout de la documentation de l'API   
Utilisez un système de génération de documentation Swagger OpenAPI. Concrètement : https://zircote.com/swagger-php/ mettez en place des annotations PHP dans le code de l’application  pour documenter les routes, les paramètres d’entrée et les réponses, en suivant la specification OpenAPI, puis générez la documentation (openapi.json) à partir de ces annotations. Vous pouvez ensuite consulter la doc sous forme UI : https://editor.swagger.io/

BONUS : Si vous avez fini, vous pouvez installer et utiliser l’interface Swagger UI en local pour visualiser directement la documentation générée : https://swagger.io/tools/swagger-ui/ / https://github.com/swagger-api/swagger-ui/releases

Si vous voyez d’autres points à ajouter, n’hésitez pas.
