<?php

namespace mywishlist\controleur;
use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\vue\VueParticipant;
use const mywishlist\vue\AFFICHER_ITEM;
use const mywishlist\vue\AFFICHER_Liste;
use const mywishlist\vue\AFFICHER_ListeS;
use const mywishlist\vue\AFFICHER_RACINE;

class ControleurAffichage{

    public function afficherLesListes(){
        $listl = Liste::all();
        $vue= new VueParticipant($listl->toArray());
        $vue->render(AFFICHER_ListeS);
    }

    public function afficherListe($no){
        $Liste = Liste::find($no);
        $vue = new VueParticipant([$Liste]);
        $vue->render(AFFICHER_Liste);
    }

    public function afficherItem($id){
        $item = Item::find($id);
        $vue = new VueParticipant([$item]);
        $vue->render(AFFICHER_ITEM);
    }

    public function racine(){
        $vue= new VueParticipant(null);
        $vue->render(AFFICHER_RACINE);
    }
}
