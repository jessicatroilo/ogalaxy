# [O’Galaxy] Conventions de nommage

Ce document va permettre de définir les conventions de nommage pour les branches et les commits sur GitHub.

## Les branches

### Les branches principales (où on ne code pas dessus)

- `main` : Ne pas toucher pendant le développement, ce sera la branche de production une fois le projet terminé.
  
- `dev` : Branche principale où nous ferons les merges des fonctionnalités validées. On ne code pas dessus !

### Les branches de développement (où on code dessus)

**Règle numéro 1 : tout en anglais !**
Nous nommerons les branches de développement de la façon suivante :

```
<type>/<name>>
```

#### Les types de branches

Le type d’une branche doit être clair afin de comprendre le but de celle-ci dès le premier coup d’œil :

- `feature` : Ajout d’une nouvelle fonctionnalité;
- `bugfix` : Correction d’un bug;
- `hotfix` : Correction d’un bug critique;
- `docs` : Ajout de documentation PHPdoc JSdoc / commentaires à notre code;
- `refactor` : Correction de code qui ne change rien au fonctionnement;
- `chore` : Nettoyage du code.

#### Les noms de branches

Deux règles à respecter ici :
- Le nom de la branche devra faire au maximum 50 caractères;
- Utilisation de la convention kebab case : tout en minuscule et séparation avec des tirets.

**Quelques exemples :**

```
git checkout -b “feature/add-booking-controller”
git checkout -b “docs/add-JSdoc-app.js”
git checkout -b “chore/cleaning-all-entities”

```

## 2. Nommer nos commits

**Règle numéro 2 : tout en anglais !**
Pour le nommage de nos commits, nous fonctionnerons de la façon suivante :

- Indiquer le type du commit qui décrit l’origine du changement (reprendre le type de la branche);
- Indiquer le scope du changement (controller, route, view, entity, etc…);
- Décrire le changement effectué.

**Quelques exemples :**

```
git commit -m  “feat(src/controller): add booking controller”
git commit -m  “docs(public/js): add JSdoc in app.js”
git commit -m  “chore(src/entity): cleaning the code of all entities”
```

## 3. Posologie

**Règle numéro 3 : tout en anglais !**
Pour que le projet soit en bonne santé (et pour ne pas avoir le mal de l’espace), nous recommandons une règle simple : au minimum un commit le midi et un commit le soir.

**Bonne pratique :** dès que le bout de code sur lequel je travaille est fonctionnel, je commit.

**Exemple :** Je travaille sur la création des routes de mon projet : dès que mes routes sont créées, je commit de la façon suivante :

```
git commit -m  “feat(src/controller): adding routes in booking controller”
```