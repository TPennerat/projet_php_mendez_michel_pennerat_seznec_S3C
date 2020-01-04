<?php

/*https://webetu.iutnc.univ-lorraine.fr/www/mendezpo1u/mywishlist/*/
session_start();

use \Illuminate\Database\Capsule\Manager as DB;
use \mywishlist\controleur\ControleurAffichage;
use \mywishlist\controleur\ControleurAdminListe;
use \mywishlist\controleur\ControleurAdminItem;
use mywishlist\controleur\ControleurConnexion;
use mywishlist\controleur\ControleurReservation;
use Slim\Slim;

require_once('vendor/autoload.php');

$app = new Slim();

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
$app->get('/afficherListe/:token/:id', function ($token, $no) {
  $c = new ControleurAffichage();
  $c->afficherListe($token, $no);
})->name('getListe');

//affichage d'une liste de souhaits
$app->get('/afficherItem/:id', function ($id) {
  $c = new ControleurAffichage();
  $c->afficherItem($id);
})->name('getItem');

//ajout d'une liste
$app->get('/creerListe', function () {
  $c = new ControleurAdminListe();
  $c->afficherFormulaire();
})->name('creerListe');

//creation de la liste avec post
$app->post('/creerListe', function () {
    $c = new ControleurAdminListe();
    $c->ajouterListeBD();
})->name('listeCree');

//ajout d'un item
$app->get('/creerItem', function () {
  $c = new ControleurAdminItem();
  $c->afficherFormulaire();
})->name('creerItem');

//creation de la liste avec post
$app->post('/creerItem', function () {
    $c = new ControleurAdminItem();
    $c->ajouterItemBD();
})->name('itemCree');

$app->get('/connexion', function (){
    $c = new ControleurConnexion();
    $c->afficherInterfaceConnexion();
})->name('connexion');

$app->post('/connexion', function (){
    $c = new ControleurConnexion();
    $c->seConnecter();
})->name('connecte');

$app->get('/inscription', function (){
    $c = new ControleurConnexion();
    $c->afficherInterfaceInscription();
})->name('inscription');

$app->post('/inscription', function (){
    $c = new ControleurConnexion();
    $c->sInscrire();
})->name('inscrit');

$app->post('/deconnexion', function(){
  $c = new ControleurConnexion();
  $c->seDeconnecter();
})->name('deconnexion');

$app->get('/suppressionListe/:token/:id', function ($token,$id){
    $c = new ControleurAdminListe();
    $c->afficherSuppressionListe($token,$id);
})->name('suppression');

$app->post('/suppressionListe/:token/:id', function ($token,$id){
    $c = new ControleurAdminListe();
    $c->supprimerListe($id);
})->name('supprimer');

$app->get('/modificationMotDePasse', function(){
    $c = new ControleurConnexion();
    $c->afficherModifierMotDePasse();
})->name('modifmdp');

$app->post('/modificationMotDePasse', function(){
    $c = new ControleurConnexion();
    $c->modifierMotDePasseUser();
})->name('modifMDPOk');

$app->get('/reservationItem/:id', function($id){
    $c = new ControleurReservation();
    $c->afficherInterfaceReserv($id);
})->name('reserv');

$app->post('/reservationItem/:id', function($id){
    $c = new ControleurReservation();
    $c->reserverItem($id);
})->name('reservOK');

$app->run();
