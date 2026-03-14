# Analyse et maintenance des applications
## Cours 6 - Design pattern
### Exercices
Dans chaque sous dossiers vous trouverez un exercice devant implémenter le design pattern correspondant au nom de ce dossier.

Pour switcher entre chaque exercice, décommenter la ligne correspondante dans le `docker-compose.yml` et faire un `docker compose down && docker compose up -d --build && docker compose run --rm php composer install` pour reconstruire le projet.

Chaque projet sera alors accessible via localhost:8080 (sauf exceptions indiquées)

---

#### BUILDER
Créer un Query Builder pour construire des requêtes SQL de manière fluide et progressive : 
- [ ] Créez une interface QueryBuilder qui représente le Query Builder. Cette classe devra avoir des méthodes pour chaque partie d'une requête de base de donnée, telles que select(), from(), where(), etc.
- [ ] Créez une classe MySqlQueryBuilder qui implement QueryBuilder avec les methodes corespondant à MySql.
- [ ] Implémentez ces méthodes pour permettre aux utilisateurs de spécifier les parties de la requête de manière progressive.
- [ ] Testez votre implémentation en créant plusieurs requêtes SQL à l'aide du Query Builder et en vérifiant qu'elles sont construites correctement, et en les affichante sous forme de texte.

---

#### DECORATOR
**Pas d'accès via localhost:8080 pour cet exercice. Pour lancer les tests : faire un "docker compose run --rm php composer run-script phpunit".**

Vous avez besoin de gérer des Ordinateur avec plusieurs déclinaisons ! Vous trouverez une class Laptop, qui implémente l'interface Computer.
Grâce au `decorator`, créer la possibilité d'ajouter une carte Graphique ou un écran OLED :
- [ ] Créez des classes décoratrices (par exemple, GPUDecorator et OLEDScreenDecorator) qui implémentent également l'interface Computer et prennent un objet Computer en paramètre dans leur constructeur. Ces classes doivent ajouter des fonctionnalités supplémentaires à l'ordinateur de base.
- [ ] Implémentez les méthodes getDescription() dans les classes décoratrices pour inclure les descriptions supplémentaires des fonctionnalités ajoutées.
- [ ] Testez votre implémentation en créant plusieurs objets Computer avec différentes combinaisons de décorateurs et en vérifiant que les descriptions sont correctes.
Une fois ces décorators créés, completer les tests et les executer 

#### FACTORY
- [ ] Vous avez 3 type de véhicule disponible. Essayez de créer une interface commune, puis de créer une factory pour obtenir l'un des 3 moyens de transports.
- [ ] Dans un second temps créer une 2e methode dans cette Factory pour obtenir un vehicule en fonction de la distance et du poids transporté (si <20km, c'est le velo, sinon c'est la voiture. Si il y a plus de 20kg ça sera la voiture et si plus de 200kg le camion.)

#### OBSERVER 
**Pas d'accès via localhost:8080 pour cet exercice. Pour lancer les tests : faire un "docker compose run --rm php composer run-script phpunit".**

Vous avez deux entités, des Utilisateur (`User`) et des groupe de musique (`MusicBand`). Si un utilisateurs suit un groupe et que ce groupe ajoute une date, l'utilisateur doit etre notifié.
- [ ] Utilisez le design pattern Observer pour remplir cette fonction. 
- [ ] La commande de tests doit retourner un resultat juste.

**note:** utilisez les interface [SplObserver](https://www.php.net/manual/fr/class.splobserver.php) et [SplSubject](https://www.php.net/manual/fr/class.splsubject.php), et ne pas modifier la classe de test.

#### SINGLETON
- [ ] Créez un classe Config qui suit le design pattern Singleton. Cette classe aura un attribut `settings` privé et une fonction `get()` qui permet de récuperer la valeur d'une clé.

---

### Rendre l'exercice
Par groupe de 2 ou 3, me fournir le rendu sur Arche, comme d'habitude, et m'indiquer qui est dans le groupe.
Faire un commit séparé pour le clone inial du repo SVP, et pour les modifications / ajouts que vous aurez réalisés. Laisser une pull request ouverte si possible, et respecter les bonnes pratiques git.