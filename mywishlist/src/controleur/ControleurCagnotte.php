<?php


namespace mywishlist\controleur;


use mywishlist\models\Account;
use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\vue\VueCagnotte;
use const mywishlist\vue\AFFICHER_CREER_CAGNOTTE_ITEM;
use const mywishlist\vue\AFFICHER_CAGNOTTE_ITEM;
use const mywishlist\vue\AFFICHER_CAGNOTTE_ITEM_INCORRECT;

class ControleurCagnotte{

  //Voir avec Théo DEBUG

  public function afficherInterfaceCagnotte($id){
      $vue = new VueCagnotte($id);
      //TESTER SI LA CAGNOTTE EXISTE DEBUG
      $vue->render(AFFICHER_CREER_CAGNOTTE_ITEM);
      //ELSE DEBUG
      $vue->render(AFFICHER_CAGNOTTE_ITEM);
  }

  public function creerCagnotte($id){
    $item = Item::find($id);
    //SSI L'ITEM n'EST PAS RESERVE DEBUG
    $item->etatCagnotte=1; //à modifier DEBUG
    $vue->render(AFFICHER_CAGNOTTE_ITEM);
  }

  public function monterCagnotte($id){
    $item = Item::find($id);
    $vue = new VueCagnotte($id);
    if (isset($_POST['val'])){
      //A MODIFIER CAR valCagnotte doit etre dans ITEM_LISTE DEBUG
      if($item->valCagnotte+$_POST['val']<=$item->tarif){
        $item->valCagnotte=$item->valCagnotte+$_POST['val'];
        $vue->render(AFFICHER_CAGNOTTE_ITEM);
      }else{
        $vue->render(AFFICHER_CAGNOTTE_ITEM_INCORRECT);
      }
    }
  }
}
