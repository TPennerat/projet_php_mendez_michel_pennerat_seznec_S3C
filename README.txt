Membres du groupe:
PENNERAT Théo
MICHEL Damien
SEZNEC Lucas
MENDEZ-PORCEL Tom


Quelques modifications par rapport au sujet initial :
Pour éviter les redondances dans la BDD, nous avons choisi de dissocier l'objet item des listes. C'est à dire qu'un item peut-être dans 0 à n listes.
Pour implémenter cette modification, nous avons du modifier certaines consignes du sujet; par exemple, dans ce cas précis, on ne peut pas modifier l'item une fois qu'il est ajouté.
Toutes les informations telles que la réservation ou les cagnottes sont donc stockées dans la table item_liste.
