<?php

namespace mywishlist\controleur;
use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\vue\VueParticipant;
use Slim\Slim;
use const mywishlist\vue\AFFICHER_ITEM;
use const mywishlist\vue\AFFICHER_LISTE;
use const mywishlist\vue\AFFICHER_LISTES;
use const mywishlist\vue\AFFICHER_RACINE;
use const mywishlist\vue\AFFICHER_LISTE_PARTAGE;
use const mywishlist\vue\BAD_TOKEN;

class ControleurAffichage{

    public function afficherLesListes(){
        $listl = Liste::all();
        $vue= new VueParticipant($listl);
        $vue->render(AFFICHER_LISTES);
    }

    public function afficherListe($token, $no){
        if($token==Liste::find($no)->token){
          setcookie("token_liste_reserv",serialize($no),0,"/");
          $Liste = Liste::find($no);
          $vue = new VueParticipant([$Liste]);
          $vue->render(AFFICHER_LISTE);
        }else if($token==Liste::find($no)->tokenPartage){
          setcookie("token_liste_reserv_pub",serialize($no),0,"/");
            setcookie("token_liste_reserv",serialize($no),0,"/");
          $Liste = Liste::find($no);
          $vue = new VueParticipant([$Liste]);
          $vue->render(AFFICHER_LISTE_PARTAGE);
        }else{
          $vue = new VueParticipant();
          $vue->render(BAD_TOKEN);
        }
    }

    public function afficherItem($id){
        $item = Item::find($id);
        $vue = new VueParticipant([$item]);
        $vue->render(AFFICHER_ITEM);
    }

    public function racine(){
        if (isset($_COOKIE['ssdm']) and isset($_COOKIE['nomUser']) and base64_decode($_COOKIE['ssdm'])=="ouissdmsvp"){
            ControleurConnexion::seConnecterViaId($_COOKIE['nomUser']);
        }
        $vue= new VueParticipant(null);
        $vue->render(AFFICHER_RACINE);
    }
}
