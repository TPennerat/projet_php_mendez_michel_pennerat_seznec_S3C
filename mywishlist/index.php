<?php

/*https://webetu.iutnc.univ-lorraine.fr/www/mendezpo1u/mywishlist/*/

use \Illuminate\Database\Capsule\Manager as DB;
use \mywishlist\controleur\ControleurAffichage;
use \mywishlist\controleur\ControleurAdminListe;

require_once('vendor/autoload.php');

$app = new \Slim\Slim();

$db = new DB();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

//affichage de la racine
$app->get('/',function () {
 $c = new ControleurAffichage();
 $c->racine();
})->name('racine');

//affichage de la liste des listes souhaits
$app->get('/afficherLesListes/token/', function () {
 $c = new ControleurAffichage();
 $c->afficherLesListes();
})->name('getListes');

//affichage d'une liste de souhaits
$app->get('/afficherListe/token/:id', function ($no) {
  $c = new ControleurAffichage();
  $c->afficherListe($no);
})->name('getListe');

//affichage d'une liste de souhaits
$app->get('/afficherItem/token/:id', function ($id) {
  $c = new ControleurAffichage();
  $c->afficherItem($id);
})->name('getItem');

//ajout d'une liste
$app->get('/creerListe', function () {
  $c = new ControleurAdminListe();
  $c->afficherFormulaire();
})->name('creerListe');

// $app->post('/creerListe', function () {
//   $c = new ControleurAdminListe();
//   $c->afficherFormulaire();
// })->name('creerListe');

$app->run();
