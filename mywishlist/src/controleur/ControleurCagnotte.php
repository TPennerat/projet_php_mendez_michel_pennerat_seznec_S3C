<?php


namespace mywishlist\controleur;


use mywishlist\models\Account;
use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\vue\VueCagnotte;
use const mywishlist\vue\AFFICHER_CREER_CAGNOTTE_ITEM;
use const mywishlist\vue\AFFICHER_CAGNOTTE_ITEM;
use const mywishlist\vue\AFFICHER_CAGNOTTE_ITEM_INCORRECT;
use const mywishlist\vue\AFFICHER_ITEM_RESERVE;

class ControleurCagnotte{

  //BDD à mettre à jour DEBUG

  public function afficherInterfaceCagnotte($id){
      $vue = new VueCagnotte($id);
      $liste = Liste::find(unserialize($_COOKIE['token_liste_reserv']));
      foreach ($liste->items as $i) {
          if ($i['id']==$id){
              $cagnotteExiste = $i->pivot->etatCagnotte;
          }
      }
      if($cagnotteExiste==0){
        $vue->render(AFFICHER_CREER_CAGNOTTE_ITEM);
      }else{
        $vue->render(AFFICHER_CAGNOTTE_ITEM);
      }
  }

  public function creerCagnotte($id){
    $item = Item::find($id);
    $liste = Liste::find(unserialize($_COOKIE['token_liste_reserv']));
    foreach ($liste->items as $i) {
        if ($i['id']==$id){
            $estReserve = $i->pivot->reserve;
        }
    }
    if($estReserve==0){
      $liste->items()->updateExistingPivot($id,["etatCagnotte"=>1]);
      $vue->render(AFFICHER_CAGNOTTE_ITEM);
    }else{
      $vue->render(AFFICHER_ITEM_RESERVE);
    }
  }

  public function monterCagnotte($id){
    $item = Item::find($id);
    $vue = new VueCagnotte($id);
    $liste = Liste::find(unserialize($_COOKIE['token_liste_reserv']));
    foreach ($liste->items as $i) {
        if ($i['id']==$id){
            $valCagnotte = $i->pivot->valCagnotte;
        }
    }
    if (isset($_POST['val'])){
      if($valCagnotte+filter_var($_POST['val'],FILTER_SANITIZE_NUMBER_FLOAT)<=$item->tarif){
        $liste->items()->updateExistingPivot($id,["valCagnotte"=>$valCagnotte+$_POST['val']]);
        $vue->render(AFFICHER_CAGNOTTE_ITEM);
      }else{
        $vue->render(AFFICHER_CAGNOTTE_ITEM_INCORRECT);
      }
    }
  }
}
