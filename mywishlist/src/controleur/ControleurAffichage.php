<?php

namespace mywishlist\controleur;
use mywishlist\models\Item;
use mywishlist\models\Liste;
use \mywishlist\vue\VueParticipant;
use const mywishlist\vue\AFFICHER_ITEM;
use const mywishlist\vue\AFFICHER_LISTE;
use const mywishlist\vue\AFFICHER_LISTES;
use const mywishlist\vue\AFFICHER_RACINE;

class ControleurAffichage{

    public function afficherLesListes(){
        $listl = Liste::all();
        $vue= new VueParticipant($listl->toArray());
        $vue->render(AFFICHER_LISTES);
    }

    public function afficherListe($no){
        $liste = Liste::find($no);
        $vue = new VueParticipant([$liste]);
        $vue->render(AFFICHER_LISTE);
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
