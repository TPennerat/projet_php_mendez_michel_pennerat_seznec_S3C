<?php
namespace mywishlist\controleur;
use mywishlist\models\Item;
use mywishlist\models\List;
use \mywishlist\vue\VueFormulaire;
use Slim\Slim;
use const mywishlist\vue\FORMUALIRE_List_INCORRECT;
use const mywishlist\vue\FORMULAIRE_List;

class ControleurAdminList {

  public function afficherFormulaire(){
      $iteml = Item::all();
      $vue = new VueFormulaire($iteml->toArray());
      $vue->render(FORMULAIRE_List);
  }

  public function ajouterListBD(){
      $app= Slim::getInstance();
      if (isset($_POST['nomList']) && isset($_POST['descr'])) {
          $nom = filter_var($app->request()->post('nomList'),FILTER_SANITIZE_STRING);
          if (count((List::select('*')->where('titre','=',$nom)->get())->toArray())==0) {
              $List = new List();
              $List->titre = $nom;
              $List->description = filter_var($app->request()->post('descr'), FILTER_SANITIZE_STRING);
              $List->save();
              $l = List::select('no')->where('titre', '=', $nom)->get();
              $List->user_id=$l['0']['no'];
              //$List->expiration=0;
              $List->token="nosecure".$l['0']['no'];
              $List->save();
              $app->redirect($app->request->getRootUri()."/afficherList/token/" . $l['0']['no']);
          }
          else {
              $iteml = Item::all();
              $vue = new VueFormulaire($iteml->toArray());
              $vue->render(FORMUALIRE_List_INCORRECT);
          }
      }
  }
}
