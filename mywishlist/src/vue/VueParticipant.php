<?php

namespace mywishlist\vue;

use mywishlist\models\Liste;
use Slim\Slim;
const AFFICHER_LISTES = 1;
const AFFICHER_LISTE = 2;
const AFFICHER_ITEM = 3;
const AFFICHER_RACINE = 4;


class VueParticipant {
  public $arr;

  public function __construct($a){
    $this->arr=$a;
  }

  private function afficherLesListes(){
    $app= Slim::getInstance();
    $content="<div id=\"mainpage\"><h2>Listes</h2></div>";
    foreach($this->arr as $l){
      $content.="<li>".$l["no"].' <a href="'.$app->urlFor('getListe', ['id'=>$l["no"]]).'">'.$l["titre"]."</a></li>";
    }

      return <<<END
    <section>$content</section>
END;
  }

  private function afficherListe($Liste){
    $app = Slim::getInstance();
    $html = "<div id=\"mainpage\"><h2>Liste</h2></div>";
    $l = Liste::find($Liste["no"]);
    $html .= "<h3>".$l->titre."</h3>";
    $html .= "<p>".$l->description."<p>";
    $items=$l->items()->get();
    foreach ($items as $item) {
      $html .= '<li>';
      $URI = Slim::getInstance()->request->getRootURI();
      $html .= "<img src=\"$URI/web/img/{$item->img}\" width=\"60\" height=\"60\" alt=\"{$item->descr}\">";
      $html .= '<a href="'.$app->urlFor('getItem', ['id'=>$item["id"]]).'">'.$item->nom.'</a>';
      $html .= '</li>';
    }
    return $html;
  }

  private function afficherItem($item){
    $html="<div id=\"mainpage\"><h2>Item</h2></div>";
    $nomitem=$item["img"];
    $URI = Slim::getInstance()->request->getRootURI();
    $descr=$item["descr"];
    $html .= "<img src=\"$URI/web/img/$nomitem\" width=\"60\" height=\"60\" alt=\"$descr\">";
    $html .= $item["nom"].' - ';
    $html .= $item["descr"];

    return $html;
  }

  private function racine(){
    $app = Slim::getInstance();
    $html = "<div id=\"mainpage\"><h2>Bienvenue sur MyWishList !</h2></div>" ;
    $html .= '<div id="reste"><p>Accès aux Listes : <a href="'.$app->urlFor('getListes').'">Listes</a></p>';
    $html .= '<p>Ajout d\'une Liste : <a href="'.$app->urlFor('creerListe').'">Liste</a></p>';
    $html .= '<p>Ajout d\'un item : <a href="'.$app->urlFor('creerItem').'">item</a></p></div>';

    return $html;
  }

  public function render($selecteur){
    $app = Slim::getInstance();
    $content = "";
    switch ($selecteur) {
      case AFFICHER_LISTES: {
        $content = $this->afficherLesListes();
        break;
      }
      case AFFICHER_LISTE : {
        $content = $this->afficherListe($this->arr[0]);
        break;
      }
      case AFFICHER_ITEM: {
        $content = $this->afficherItem($this->arr[0]);
        break;
      }
      case AFFICHER_RACINE : {
        $content = $this->racine();
        break;
      }
    }
    $urlRacine=$app->urlFor('racine');
    $urlCSS=$app->request->getRootURI().'/web/style.css';
    $urlConnexion=$app->urlFor('connexion');
    $urlInscription=$app->urlFor('inscription');
    $html = <<<END
<!DOCTYPE html>
<html lang="fr">
<head>
  <title>MyWishList</title>
  <link rel="stylesheet" type="text/css" href="$urlCSS">
</head>
<body>
  <div class="header">
    <h1><a id="mywishlist" href="$urlRacine">MyWishList</a></h1>
    <span>
    <a id="conn" href="$urlInscription">Inscription</a>
    </span>
    <span>
    <a id="conn" href="$urlConnexion">Connexion</a>
    </span>
  </div>
  <div class="content">
   $content
  </div>
</body>
</html>
END;
  echo $html;
  }

}
