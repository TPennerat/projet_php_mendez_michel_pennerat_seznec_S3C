<?php
namespace mywishlist\controleur;
use mywishlist\models\Liste;
use \mywishlist\vue\VueFormulaire;
use Slim\Slim;
use const mywishlist\vue\FORMULAIRE_LISTE;

class ControleurAdminListe {

  public function afficherFormulaire(){
      $iteml = \mywishlist\models\Item::all();
      $vue = new VueFormulaire($iteml->toArray());
      $vue->render(FORMULAIRE_LISTE);
  }

  public function ajouterListeBD(){
      $app= Slim::getInstance();
      if (isset($_POST['nomListe']) && isset($_POST['descr'])) {
          $nom = filter_var($app->request()->post('nomListe'),FILTER_SANITIZE_STRING);
          if (count((Liste::select('*')->where('titre','=',$nom)->get())->toArray())==0) {
              $liste = new Liste();
              $liste->titre = $nom;
              $liste->description = filter_var($app->request()->post('descr'), FILTER_SANITIZE_STRING);
              $liste->save();
              $l = Liste::select('no')->where('titre', '=', $nom)->get();
              $app->redirect($app->request->getRootUri()."/afficherListe/token/" . $l['0']['no']);
          }
      }
  }
}
