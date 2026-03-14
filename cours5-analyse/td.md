# Analyse et maintenance des applications
## Cours 5 - TD
### Objectifs du TD
Analyser un projet existant, le faire marcher en local, lister les dépendances/frameworks obsolètes, et proposer des améliorations pour la maintenance future.

Créez un fichier notes.md pour noter toutes vos observations. Devrons y figurer une fiche d'identification du projet, et les éventuelle actions réalisées et leur explication.

Le but n'est pas d'avoir un document administratif complexe, juste du contexte pour vous et les autres personnes qui travailleraient sur le projet.

### Exercice
#### Préambule : 
/!\ on ne fait pas ici d'ajout de fonctionnalités mais de la maintenance applicative (sécurité, fiabilité, amélioration du code, etc.). Pensez aux choses vues dans le 1er module (automatisation du dev.), et dans ce cours.

#### Etapes à réaliser
1. **Analyse théorique** (30min)
Sans lancer le projet, essayez de répondre aux questions suivantes, et notez vos réponses dans le fichier notes.md :
- [ ] Trouver le ou les langages utilisé 
- [ ] Trouver le ou les framework principaux utilisé
- [ ] Trouvez le but général de l'application
- [ ] Faire une première estimation de ce qu'il faudrait pour faire démarrer l'application en l'état

2. **Prise en main & démarrage** (30min)
- [ ] Faire marcher l'application en local
- [ ] Créer un process et un mode d'emploi pour faire marcher l'application (un docker-compose et un readme, par exemple)

3. **Préparer la maintenance** (30min)
- [ ] Lister les langages et frameworks dont la version est obsolète
- [ ] Lister les dépendances non maintenues / obsolètes
- [ ] Notez dans une section "Todo list" d'autres améliorations que vous avez en tête pour la maintenance et l'évolution de l'application. Gardez en tête le préambule ci dessus.
- [ ] Pour chaque idée, essayer de noter sur 10 le temps de la modification, et l'impact de la modification (2 notes donc) afin de prioriser les évolutions futures.

4. **Réaliser la maintenance** (1h30)
- [ ] Mettre à jour les versions de langages et de framework
- [ ] Mettre à jour les dépendances obsolètes

5. **Étape (bonus) - effectuer de l'amélioration continue**
- [ ] Appliquer certaines des améliorations que vous aviez envisagées en étape 3
- [ ] Faire une liste des améliorations que vous avez faites, avec une explication rapide de pourquoi vous avez séléctionné celle(s)-ci parmi vos idées initiales._

### Rendre l'exercice
Par groupe de 2 ou 3, me fournir le rendu sur Arche, comme d'habitude, et m'indiquer qui est dans le groupe. 

Dans le repo, fournissez moi le notes.md avec vos réponses + le code incluant vos modifications. 

Faire un commit séparé pour le clone inial du repo SVP, et pour les modifications / ajouts que vous aurez réalisés. Laisser une pull request ouverte si possible, et respecter les bonnes pratiques git.