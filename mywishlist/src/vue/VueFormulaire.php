<?php

namespace mywishlist\vue;

use Slim\Slim;
const FORMULAIRE_LISTE = 1;
const FORMULAIRE_ITEM = 2;
const FORMUALIRE_LISTE_INCORRECT = 3;

class VueFormulaire {
    public $arr;

    public function __construct($a){
        $this->arr=$a;
    }

    private function formulaireListeIncorrect(){
        $html="<h2>Création d'une liste</h2>";
        $html.='<div align="center">';
        $html .='<form id="f1" method="post" action="creerListe">';
        $html .= '<p style="color: red">Nom de liste déjà existant</p>';
        $html .= '<input type="text" name="nomListe" required placeholder="Nom de la liste">';
        $html .= '<input type="text" name="descr" placeholder="Description">';
        foreach($this->arr as $i){
            $html .= '<p><label>'.$i['nom'].'<input type="checkbox" name="'.$i['id'].'" id="'.$i['id'].'"></p>';
        }
        $html .= '<button type=submit name="valider">Valider</button>';
        $html .='</form>';
        $html.='</div>';

        return $html;
    }

    private function formulaireListe(){
        $html="<h2>Création d'une Liste</h2>";
        $html.='<div align="center">';
        $html .='<form id="f1" method="post" action="creerListe">';
        $html .= '<input type="text" name="nomListe" required placeholder="Nom de la Liste">';
        $html .= '<input type="text" name="descr" placeholder="Description">';
        foreach($this->arr as $i){
            $html .= '<p><label>'.$i['nom'].'<input type="checkbox" name="'.$i['id'].'" id="'.$i['id'].'"></p>';
        }
        $html .= '<button type=submit name="valider">Valider</button>';
        $html .='</form>';
        $html.='</div>';

        return $html;
    }

    private function formulaireItem(){
        $html="<h2>Création d'un item</h2>";
        $html .='<form id="f2" method="post" action="creerItem" enctype="multipart/form-data">';
        $html .= '<input type="text" name="nomItem" required placeholder="Nom de l\'item">';
        $html .= '<input type="text" name="descr" placeholder="Description">';
        $html .= '<select name="select">';
        foreach($this->arr as $i){
            $html .= '<option value="'.$i['no'].'">'.$i['titre'].'</option>';
        }
        $html.='</select><br>';
        //$html .= '<input type="hidden" name="MAX_FILE_SIZE" value="30000">';
        $html .= '<input type="file" name="image">';
        $html .= '<input type=submit name="valider">';
        $html .='</form>';

        return $html;
    }

    public function render($selecteur){
        $app = Slim::getInstance();
        $content = "";
        switch ($selecteur) {
            case FORMULAIRE_LISTE: {
                $content = $this->formulaireListe();
                break;
            }
            case FORMULAIRE_ITEM: {
                $content = $this->formulaireItem();
                break;
            }
            case FORMUALIRE_LISTE_INCORRECT: {
                $content = $this->formulaireListeIncorrect();
                break;
            }
        }
        $urlRacine=$app->urlFor('racine');
        $urlCSS=$app->request->getRootURI().'/web/style.css';
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
