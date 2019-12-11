<?php

namespace mywishlist\controleur;
use \mywishlist\vue\VueParticipant;
use const mywishlist\vue\AFFICHER_ITEM;
use const mywishlist\vue\AFFICHER_LISTE;
use const mywishlist\vue\AFFICHER_LISTES;
use const mywishlist\vue\AFFICHER_RACINE;

class ControleurAffichage{
  public function afficherLesListes(){
    $listl = \mywishlist\models\Liste::all();
    $vue= new VueParticipant($listl->toArray());
    $vue->render(AFFICHER_LISTES);
  }

  public function afficherListe($no){
    $liste = \mywishlist\models\Liste::find($no);
    $vue = new VueParticipant([$liste]);
    $vue->render(AFFICHER_LISTE);
  }

  public function afficherItem($id){
    $item = \mywishlist\models\Item::find($id);
    $vue = new VueParticipant([$item]);
    $vue->render(AFFICHER_ITEM);
  }

  public function racine(){
    $vue= new VueParticipant(null);
    $vue->render(AFFICHER_RACINE);
  }
}
