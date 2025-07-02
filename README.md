## Instructions pour rendre le projet fonctionnel
Note: j'ai montée le projet avec Docker en mode WSL, sur Windows
1) Faire un git pull
2) Dans le dossier du projet, faire la commande suivante:
   docker compose build
3) Rouler la commande suivante:
   docker-compose run --rm composer install
4) Rouler la commande suivante:
   docker-compose run --rm  npm install
5) dans le dossier src, créer un ficheir .env à aprtir du .env.example
6) rouler la commande suivante:
   docker-compose run --rm  artisan migrate
8) Rouler la commande suivante:
   docker-compose run --rm --service-ports  npm run dev

## Choix de design et stratégie
Vu la contrainte de temps et le petit nombre de fonctionnalités demandées, j'ai choisi de monter le projet en Single Page Application, avec le routage fait au niveau du front end, dans Vue. Cela élimine la configuration plus lourde de l'authentification et des routes.
J'ai utilisé la librairie axios afin de communiquer entre le frontend et le backend de l'application sans avoir à passer des variables par le biais des pages blade.
Vue le focus précis de l'application, j'ai opté pour faire un unique controlleur qui s'occupe de toutes les intéractions avec la base de données et qui renvoie .
Le style visuel de la page a été construit avec des templates de base de tailwind.
Pour ce qui est de la base de données, j'ai décidé de placer le champs "discount_rate" au niveau de la facture, et non de ses lignes pour 2 raisons. 1) La remise s'applique pour l'instant sur la facture entière et 2) Si l'application évolue et permet éventuellement aussi les remises individuelles, ça simplifie les choses.
Les seuls prix gardés en base de données sont ceux les prix unitaires des lignes de factures. Trois décimales sont gardées cau cas où on persiste éventuellement le prix payé, dans quel cas la remise pourrait engendrer des fractions de sous.

## Ommissions
Je n'ai pas eu le temps d'implémenter l'authentification ou d'utiliser JSON:API
La configuration de docker et me familiariser avec l'utilisation de Vue à travers Laravel, ne les ayant utilisé que séparément auparavant,
m'a pris plus de temps que j'aurais souhaité. J'ai donc priorisé le fait d'avoir les fonctionnalités de base du site. Dans un contexte professionel où la sécurité est un enjeu, je n'aurais toutefois pas mis de côté l'authentification.
Mon but était initialement d'utiliser axios pour communiquer entre le frontend et le backend à l'aide de resources JSON:API, mais ai décidé de spécifier la structure de données à la main dans le controlleur

## Suite
Si j'avais à continuer le projet, je ferais les modifications nécessaires pour utiliser JSON:API avant d'aller plus loin, j'implémenterais l'aauthentification je rajouterais des validations frontend et backend sur la majorité des champs et je rendrais ceux-ci en lecture seule dépendemment du statut de la facture
