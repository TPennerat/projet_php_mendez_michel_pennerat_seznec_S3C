<?php

namespace mywishlist\vue;
class VueFormulaire {
  public $arr;

  public function __construct($a){
    $this->arr=$a;
  }

  private function formulaireListe(){
    $html="<h2>Création d'une liste</h2>";
    $html .='<form id="f1" method="post" action="creerListe">';
    $html .= '<input type="text" name="nomListe" placeholder="Nom de la liste">';
    $html .= '<input type="text" name="descr" placeholder="Description">';

    $app = \Slim\Slim::getInstance();
    foreach($this->arr as $i){
      $html .= '<p><label>'.$i['nom'].'<input type="checkbox" name="'.$i['nom'].'" id="'.$i['id'].'"></p>';
    }
    $html .= '<button type=submit name="valider">Valider</button>';
    $html .='</form>';

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
