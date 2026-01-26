# Automatisation du développement
## Cours 4 - TD
### Objectifs du TD
Il faut créer rapidement une petite application symfony (liste de films et liste de réalisateurs, avec leurs informations de bases, + une relation entre les 2 entités), avec les Maker proposées par le framework.

Puis y ajouter linters/tests, et automatiser leur execution au déploiement grâce à GitHub Actions. 

### Instructions
Prérequis : installer le projet (voir README.md du dossier td_backend). 

Lire les conseils ci dessous avant de commencer + lire le cours associé.

1. **Prendre en main les Makers** (1h)
   - [ ] Générer les classes nécessaires au projet : 
      - [ ] Les _entités_ correspondantes. Ajoutez quelques champs très basiques.  Il doit y avoir une relation entre Réalisateur et Film.
      - [ ] Les _controlleurs_ associés, et leurs vues twig. Vous devez pouvoir accéder aux vues via les routes générées.
      - [ ] Le fichier de _migration_ & executer la migration pour initialiser la base avec les bonnes tables.
      - [ ] Une (une seule !) _fixture_ qui peuplera les deux entités (et leur relation) - utiliser FakerPHP pour avoir des données aléatoires. Executer cette fixture pour insérer les données en base.
   - [ ] Modifier les vues pour remonter les données (de maniere très basique, pas de mise en forme css etc., juste du brut pour l'exemple)
   - [ ] Bonne pratique : Indiquer dans le readme du projet comment initialiser les données, ainsi que l'url des 2 vues. => Mettez vous a la place d'un nouveau développeur qui arrive sur le projet : il n'aura pas à rééxecuter tout ce que vous venez de faire, uniquement 2 commandes précises, c'est celles ci qu'il faudra m'indiquer.
   
2. **Linters et tests PHP** (15min)
   - [x] Php Unit, PHPStan et PHPCs sont déja ajoutés au projet. Ils ont déja des fichiers de configuration de base.
   - [ ] Créer des classes de test basiques pour les 2 entités (quelques tests dans chaque pour la démo). Bien structurer les dossiers de tests.
   - [x] Pas besoin de code coverage, ni de tout tester, ce n'est pas le but aujourd'hui, mais si vous avez envie vous pouvez le faire !
   - [ ] S’assurer que les linters et tests unitaires fonctionnent et passent correctement en local => corriger les erreurs eventuelles (sinon votre code ne passera pas la CI/CD plus tard !)

3. **Configurer un pipeline de tests & linters via GitHub Actions ou via GitLab CI** (1h30)
    - [ ] Créer un fichier de config CI selon la plateforme utilisée, comprenant :
      - [ ] L'installation des dépendances (composer, phpcs, phpstan, phpunit), déplacement dans l'arbo, copie du .env manquant, etc.. => tout ce qui est nécessaire pour que les jobs suivants puissent s’exécuter correctement. La CI doit déja correctement s'executer ici, même si elle ne fait rien.
      - [ ] L'execution les linters et les tests, qui devraient être OK puisque vous les aurez joués en local ci-dessus.
      - [ ] Une étape qui simulera un déploiement en prod. (avec juste des commandes `echo` par exemple, pas besoin d'executer quoi que ce soit ici c'est juste pour comprendre).
      - [ ] Si un job échoue, les suivants ne doivent pas s’exécuter. En effet, si vos linters ou tests échouent, le déploiement ne doit pas se faire (la CI ne doit pas fixer le code, juste le rejetter).
    - [ ] Tester le push du code, et suivre l'execution de la CI/CD sur github/gitlab. => je devrai pouvoir y voir dans l'interface un pipeline executé, comprenant toutes les étapes demandées.

### Conseils
#### Makers :
- Doc symfony : https://symfony.com/doc. Vous y trouverez une section Makers (+ une section Relations entre entités). Vous y trouverez aussi la doc sur comment créer une fixtures avec Make.
- Suivez les instructions du maker. La valeur entre crochet est la valeur par défaut. Si vous faites une erreur il faut supprimer les fichiers générés et recommencer.
- NB : Une base de données sqlite est déjà configurée, vous n'avez qu'à lancer les migrations, pas besoin d'image mysql (voir dans le fichier .env, et dans /var/data.db si cela vous intéresse)

#### Github Actions / GitLab CI :
- Le fichier de config doit être à la _racine du dépot GIT_, c'est à dire au dessus de "cours1", "cours2" etc. le cas échéant. Veillez à bien se redéplacer dans le dossier cours4 au début de l'execution des actions de CI.
- La CI doit être lisible, et documentée : ajoutez des commentaires qui seront affichés lors de l'execution (que vous pourrez suivre dans l'interface github/gitlab)
- Faites au plus simple pour l'instant => tout executer à la chaine dans un seul job. Mais si vous avez le temps, vous pouvez découper en plusieurs jobs, par exemple un pour les linters, un pour les tests, et un pour le déploiement simulé (c'est plus simple sur gitlab que sur github...)
- Pour rejetter sortir de la CI si une étape à failé : voir cours.
- Doc GitHub Actions : https://docs.github.com/fr/actions/get-started/quickstart
- Doc GitLab CI : https://docs.gitlab.com/ee/ci/quick_start/ / https://cto-externe.fr/actualites-developpement/deploiement-php-gitlab-ci-cd/

### Rendre l'exercice
Par groupe de 2 ou 3, me fournir le lien sur Arche, comme d'habitude. Laisser une pull request ouverte si possible, et respecter les bonnes pratiques git.
Le repo devra comprendre le code symfony avec les modifications apportées par les makers + le fichier de migration + les tests et le code corrigé suite aux linters + la fixture + le fichier github actions / gitlab ci (à la racine du repo). 

---

### Exercice _facultatif_ non noté (si la séance est terminée en avance, ou pour aller plus loin) : 
https://github.com/ChristopheSauder/cours-4-frontend/blob/main/EXERCICE.md