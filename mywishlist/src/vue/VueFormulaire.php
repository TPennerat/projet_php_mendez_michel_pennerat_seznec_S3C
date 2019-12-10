<?php

namespace mywishlist\vue;
class VueFormulaire {
  public $arr;

  public function __construct($a){
    $this->arr=$a;
  }

  private function formulaireListe(){
    $html="<h2>Création d'une liste</h2>";
    $html .= '<input type="text" placeholder="nom de la liste">';
    $html .= '<input type="text" placeholder="description">';

    $app = \Slim\Slim::getInstance();
    $items = \mywishlist\models\Item::all(); //peut etre à mettre dans le ocntroleur puis dans arr
    foreach($items as $i){
      $html .= '<label>'.$i->nom.'<input type="radio" name="groupe-radio1" value='.$i->id;
    }
    $html .= '<button type="submit">valider</button>';

    return $html;
  }



  public function render($selecteur){
    $app = \Slim\Slim::getInstance();
    switch ($selecteur) {
      case 1: {
        $content = $this->formulaireListe();
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
  <h1>MyWishList</h1>
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
