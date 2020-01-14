------------------------------ PROJET MyWishlist S3C ------------------------------

Membres du groupe:
PENNERAT Théo
MICHEL Damien
SEZNEC Lucas
MENDEZ-PORCEL Tom

Le document excel "Projet.xlsx" contient les correspondances entre les routes dans l'index et les fonctionnalités

Quelques modifications par rapport au sujet initial (fonctionnalités 10, 11, 12 et 13 non réalisées volontairement) :

- Pour éviter les redondances dans la BDD, nous avons choisi de dissocier l'objet item des listes. C'est à dire qu'un item peut-être dans 0 à n listes.
Pour implémenter cette modification, nous avons du modifier certaines consignes du sujet; par exemple, dans ce cas précis, on ne peut pas modifier l'item une fois qu'il est ajouté.
Toutes les informations telles que la réservation ou les cagnottes sont donc stockées dans la table item_liste.
On justifie ce choix car une grande majoritié des cadeaux sont communs à beaucoup de personnes (objets de marques, consoles de jeux...)

- Nous avons également considéré que c'est les participants qui peuvent choisir d'ouvrir une cagnotte, si tel est le cas, la réservation devient impossible (et inversement).
Cette fois, nous avons éstimé que c'est au participant de gérér cet aspect et pas à la personne qui crée la liste.


Fonctionnalités  16 (25 26 27 28) à faire