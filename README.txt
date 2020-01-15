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



------------------------------- INSTALLER LE PROJET ------------------------------

Pour installer le projet sur une machine perso, vous devez créer un fichier conf.ini dans src/conf/ (créer le dossier conf aussi)
Puis creer un fichier .htaccess au même niveau que l'index, comme ceci :

RewriteEngine On

# Pour interdire l'accès aux répertoires contenant du code
RewriteRule ^sql(/.*|)$ - [NC,F]
RewriteRule ^src(/.*|)$ - [NC,F]
RewriteRule ^vendor(/.*|)$ - [NC,F]

#
# réécriture pour slim

RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^ index.php [QSA,L]

Ensuite vous devez créer votre propre base de donnée (mySQL de préférence) et y injecter le script mywishlist.sql se trouvant à la racine.

Puis faites composer install dans le dossier mywishlist

Vous voilà maintenant prêt pour lancer le projet en local

--------------------------------------------------------------------------

Lien vers WEBETU : https://webetu.iutnc.univ-lorraine.fr/www/mendezpo1u/mywishlist/
