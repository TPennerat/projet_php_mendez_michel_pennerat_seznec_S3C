<?php

namespace mywishlist\controleur;
use mywishlist\models\Item;
use mywishlist\models\List;
use mywishlist\vue\VueParticipant;
use const mywishlist\vue\AFFICHER_ITEM;
use const mywishlist\vue\AFFICHER_List;
use const mywishlist\vue\AFFICHER_ListS;
use const mywishlist\vue\AFFICHER_RACINE;

class ControleurAffichage{

    public function afficherLesLists(){
        $listl = List::all();
        $vue= new VueParticipant($listl->toArray());
        $vue->render(AFFICHER_ListS);
    }

    public function afficherList($no){
        $List = List::find($no);
        $vue = new VueParticipant([$List]);
        $vue->render(AFFICHER_List);
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
