# Automatisation du développement
## Cours 3 - TD

**TOUT SE PASSE DANS LE DOSSIER cours-3-TD -> phpunit & vitest**

### Préalable
Bien lire les readme disponible dans chaque partie pour comprendre son fonctionnement et comment l'installer.
Bien lire les MD td.PHPUnit.md et td.Vitest.md qui contiennent des informations importantes pour réaliser cet exercice.
N'hésitez pas à vous aider des exercices vus juste avant (dossier "Interlude")

### Objectif
L'objectif de cet exercice est de vous faire pratiquer l'écriture de tests unitaires et fonction
Après avoir parcours les différentes classes, vous devrez écrire les tests pour couvrir l'intégralité des use case de ce projet.
Vous devrez avoir une attention particulière à la structure de vos dossiers test

#### Partie PHPUnit (le projet n'affiche rien, c'est normal)
**Vous ne devez pas modifier les classes Entity**, ni changer la visibilité de leurs membres (utilisez des mock dans les tests si besoin).
Utilisez des dataProvider et des fixtures lorque que cela vous semble pertinant.

Rendu : 3 classes de tests et un rapport de code coverage à 100%. Tous les tests doivent passer et ils doivent être pertinents.
- [] Corrigez le fichier `phpunit.xml` pour la configuration de PHPUnit (=> pour y inclure les bons répertoires de test et de sources)
- [] Ecrire les tests pour `Person`, 
- [] Ecrire les tests pour `Wallet` 
- [] Ecrire les tests pour `Product`.
- [] Générer un rapport code coverage (attention : il est dans le git ignore, inutile de le rajouter au repo mais vous devez me mettre une **capture d'écran du résultat** dans le projet)

#### Partie Vitest (le projet affiche une petite interface Vue, cf readme)
Rendu : 4 classes de tests pour les composant, le router et le store. Rapport de code coverage. Tous les tests doivent passer et ils doivent être pertinents.
- [] Corrigez le fichier de configuration `vitest.config.js` à la racine du projet ( => pour ne pas polluer votre coverage, il faudra y exclure les fichiers '.eslintrc.cjs' et 'src/main.js' du rapport).
- [] Ecrire les tests pour les composants `Counter` et `InputText`
- [] Ecrire les tests du router pour vérifier que le router navigue bien sur les bonnes pages.
- [] Ecrire les tests pour vérifier que les methodes du store sont corrects
- [] Générer un rapport code coverage (attention : il est dans le git ignore, inutile de le rajouter au repo mais vous devez me mettre une **capture d'écran du résultat** dans le projet)

### Rendre l'exercice
Par groupe de 2 ou 3.
Vous trouverez sur Arche un endroit où déposer un fichier contenant le lien de votre repo GIT auquel je devrai avoir accès (ou m'envoyer par mail) ! Précisez-moi qui est dans le groupe.