<?php

namespace mywishlist\vue;

class VueParticipant {
  public $arr;

  public function __construct($a){
    $this->arr=$a;
  }

  private function afficherLesListes(){
    $app=\Slim\Slim::getInstance();
    $content="<h2>Listes</h2>";
    foreach($this->arr as $l){
      $content.="<li>".$l["no"].' <a href="'.$app->urlFor('getListe', ['id'=>$l["no"]]).'">'.$l["titre"]."</a></li>";
    }

    $html = <<<END
    <section>$content</section>
END;
    return $html;
  }

  private function afficherListe($liste){
    $app = \Slim\Slim::getInstance();
    $html = "<h2>Liste</h2>";
    $l = \mywishlist\models\Liste::find($liste["no"]);
    $items=$l->items()->get();
    foreach ($items as $item) {
      $html .= '<li>';
      $URI = \Slim\Slim::getInstance()->request->getRootURI();
      $html .= "<img src=\"$URI/web/img/{$item->img}\" width=\"60\" height=\"60\">";
      $html .= '<a href="'.$app->urlFor('getItem', ['id'=>$item["id"]]).'">'.$item->nom.'</a>';
      $html .= '</li>';
    }
    return $html;
  }

  private function afficherItem($item){
    $html="<h2>Item</h2>";
    $nomitem=$item["img"];
    $URI = \Slim\Slim::getInstance()->request->getRootURI();
    $html .= "<img src=\"$URI/web/img/$nomitem\" width=\"60\" height=\"60\">";
    $html .= $item["nom"].' - ';
    $html .= $item["descr"];

    return $html;
  }

  private function racine(){
    $app = \Slim\Slim::getInstance();
    $html = "<h2>Racine</h2>" ;
    $html .= 'Accès aux listes : <a href="'.$app->urlFor('getListes').'">listes</a><br>';

    return $html;
  }

  public function render($selecteur){
    $app = \Slim\Slim::getInstance();
    switch ($selecteur) {
      case 1: {
        $content = $this->afficherLesListes();
        break;
      }
      case 2 : {
        $content = $this->afficherListe($this->arr[0]);
        break;
      }
      case 3: {
        $content = $this->afficherItem($this->arr[0]);
        break;
      }

      case 4 : {
        $content = $this->racine();
        break;
      }
    }
    $urlRacine=$app->urlFor('racine');
    $urlCSS=$app->request->getRootURI().'/web/style.css';
    $html = <<<END
<!DOCTYPE html>
<html>
<head>
  <title>MyWishList</title>
  <link rel="stylesheet" type="text/css" href="$urlCSS">
</head>
<body>
  <div class="header">
    <h1>MyWishList</h1>
  </div>
  <div class="content">
   $content
  </div>
  <footer><p>URL de la racine : <a href="$urlRacine">racine</a><p></footer>
</body>
<html>
END;
  echo $html;
  }

}
