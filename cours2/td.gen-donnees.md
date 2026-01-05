# Génération de données dans le développement
## FakerPHP
- [Documentation officielle](https://fakerphp.github.io/)
- [Page Packagist](https://packagist.org/packages/fakerphp/faker)

FakerPHP est une **librairie puissante** qui simplifie considérablement la génération de données. Elle inclut des générateurs pour de nombreux types de données courantes (prénoms, adresses, mails, coordonnées, etc.).  
Elle supporte également plusieurs localisations, ce qui permet d’obtenir des données adaptées (formats d’adresse et dates françaises, par exemple) et de gérer plusieurs pays dans une même application, avec des formats adaptés.

## Datafixture/Seeder
Dans un projet, il est important de peupler la base de données avec des données cohérentes. Plusieurs méthodes existent :
1. **Récupérer la base de production**  
   **+** Données réelles, problèmes réels facilement reproduits  
   **-** Il faut avoir accès à une base de production   
   **-** Il faut avoir le droit de la récupérer
   **-** Risque de fuite de données confidentielles 
   **Conclusion** : idéalement à éviter

2. **Construire un jeu de données statique**  
   **+** Peut être modelé exactement pour reproduire des comportements souhaités
   **+** Facilité de partage via script d’import  
   **-** Fastidieux à maintenir  
   **-** Risque de ne pas couvrir tous les cas d’usage  
   **-** Ne contiendra jamais beaucoup de données  
   **-** Tous les utilisateurs couvrent les mêmes cas  
   **Conclusion** : démarche intéressante, mais limitée

3. **Prévoir une commande générant automatiquement des données**  
   **+** Facile à écrire et maintenir  
   **+** Script versionné ce qui permet de travailler sur des évolutions sans impacter la branche principale  
   **+** Possibilité de générer rapidement un grand volume de données  
   **+** Facilite les tests  
   **Conclusion** : solution idéale à privilégier  

**L'idéale est donc de rédiger un script qui permet de générer des données fictives.**

Symfony et Laravel proposent respectivement les **Datafixtures** et **Seeders** qui remplissent ce rôle : peupler la base via une simple commande.  

- [Documentation Symfony](https://symfony.com/bundles/DoctrineFixturesBundle/current/index.html)  
- [Documentation Laravel](https://laravel.com/docs/10.x/seeding)

Par défaut, ces commandes purgent la base avant de recréer un jeu de données. Même si vous n’utilisez pas ces frameworks, il est recommandé de s’en inspirer.

**Bonnes pratiques**
- Créer des fonctions pour chaque type d’entité (générer une personne, une société, un article, etc.).  
- Cela simplifie le code, améliore la lisibilité et facilite les évolutions.