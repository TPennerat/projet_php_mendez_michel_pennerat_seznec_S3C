<?php
namespace mywishlist\controleur;
use mywishlist\models\Liste;
use \mywishlist\vue\VueFormulaire;
use mywishlist\vue\VueParticipant;
use Slim\Slim;

class ControleurAdminListe {

  //methode potentielle
  public function getListe($no){

  }

  public function afficherFormulaire(){
      $iteml = \mywishlist\models\Item::all();
      $vue = new VueFormulaire($iteml->toArray());
      $vue->render(1);
  }

  public function ajouterListeBD(){
      $app= Slim::getInstance();
      if (isset($_POST['nomListe']) && isset($_POST['descr'])) {
          $nom = $app->request()->post('nomListe');
          $liste=new Liste();
          $liste->titre=filter_var($nom,FILTER_SANITIZE_STRING);
          $liste->description=filter_var($app->request()->post('descr'),FILTER_SANITIZE_STRING);
          $liste->save();
          $l = Liste::select('no')->where('titre','=',$nom)->get();
          $vue = new VueParticipant($l->toArray());
          $vue->render(2);
      }
  }
}
