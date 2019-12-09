<?php

namespace mywishlist\controleur;
use \mywishlist\vue\VueParticipant;

class ControleurAffichage{
  public function afficherLesListes(){
    $listl = \mywishlist\models\Liste::all();
    $vue= new VueParticipant($listl->toArray());
    $vue->render(1);
  }

  public function afficherListe($no){
    $liste = \mywishlist\models\Liste::find($no);
    $vue = new VueParticipant([$liste]);
    $vue->render(2);
  }

  public function afficherItem($id){
    $item = \mywishlist\models\Item::find($id);
    $vue = new VueParticipant([$item]);
    $vue->render(3);
  }

  public function racine(){
    $vue= new VueParticipant(null);
    $vue->render(4);
  }
}
