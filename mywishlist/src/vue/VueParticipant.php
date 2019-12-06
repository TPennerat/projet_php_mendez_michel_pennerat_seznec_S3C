<?php

namespace mywishlist\vue;
class VueParticipant {
  public $arr;

  public function __construct($a){
    $this->arr=$a;
  }

  private function afficherLesListes(){
    $content="";
    foreach($this->arr as $l){
      $content.="<li>".$l["no"].' '.$l["titre"]."</li>";
    }

    $html = <<<END
    <section>$content</section>
END;
    return $html;
  }

  private function afficherListe($liste){
    $html = "";
    $l = \mywishlist\models\Liste::find($liste["no"]);
    $items=$l->items()->get();
    foreach ($items as $item) {
      $html .= '<li>';
      $URI = \Slim\Slim::getInstance()->request->getRootURI();
      $html .= "<img src=\"$URI/web/img/{$item->img}\" width=\"60\" height=\"60\">";
      $html .= $item->nom.' - ';
      $html .= $item->descr;
      $html .= '</li>';
    }
    return $html;
  }

  private function afficherItem($item){
    $html="";
    $nomitem=$item["img"];
    $URI = \Slim\Slim::getInstance()->request->getRootURI();
    $html .= "<img src=\"$URI/web/img/$nomitem\" width=\"60\" height=\"60\">";
    $html .= $item["nom"].' - ';
    $html .= $item["descr"];

    return $html;
  }

  public function render($selecteur){
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
    }
    $html = <<<END
<!DOCTYPE html>
<html>
<head><title>AfficherLesListes</title></head>
<body>
<div class="content">
 $content
</div>
</body><html>
END;
  echo $html;
  }

}
