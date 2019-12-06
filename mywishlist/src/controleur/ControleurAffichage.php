<?php

namespace mywishlist\controleur;
use \mywishlist\vue\VueParticipant;

class ControleurAffichage{
  public function racine(){
    //A MODFIER
    echo "<h2>Racine</h2>" ;
    $app = \Slim\Slim::getInstance();
    echo 'URL de la racine : '.$app->urlFor('racine').'<br>';
    echo 'URL de getListes : '.$app->urlFor('getListes').'<br>';
    echo 'URL de getListe : '.$app->urlFor('getListe', ['id'=>0]).'<br>';
    echo 'URL de getItem : '.$app->urlFor('getItem', ['id'=>0]).'<br>';
  }

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
}
