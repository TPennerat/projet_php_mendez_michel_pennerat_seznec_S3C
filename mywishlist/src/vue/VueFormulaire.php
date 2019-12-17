<?php

namespace mywishlist\vue;

use Slim\Slim;
const FORMULAIRE_List = 1;
const FORMULAIRE_ITEM = 2;
const FORMUALIRE_List_INCORRECT = 3;

class VueFormulaire {
    public $arr;

    public function __construct($a){
        $this->arr=$a;
    }

    private function formulaireListIncorrect(){
        $html="<h2>Création d'une List</h2>";
        $html.="<p style='color : red'>Impossible de créer votre List, ce nom existe déjà !</p>";
        $html .='<form id="f1" method="post" action="creerList">';
        $html .= '<input type="text" name="nomList" placeholder="Nom de la List">';
        $html .= '<input type="text" name="descr" placeholder="Description">';
        foreach($this->arr as $i){
            $html .= '<p><label>'.$i['nom'].'<input type="checkbox" name="'.$i['nom'].'" id="'.$i['id'].'"></p>';
        }
        $html .= '<button type=submit name="valider">Valider</button>';
        $html .='</form>';

        return $html;
    }

    private function formulaireList(){
        $html="<h2>Création d'une List</h2>";
        $html.='<div align="center">';
        $html .='<form id="f1" method="post" action="creerList">';
        $html .= '<input type="text" name="nomList" required placeholder="Nom de la List">';
        $html .= '<input type="text" name="descr" placeholder="Description">';
        foreach($this->arr as $i){
            $html .= '<p><label>'.$i['nom'].'<input type="checkbox" name="'.$i['nom'].'" id="'.$i['id'].'"></p>';
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
        $html .= '<input type="hidden" name="MAX_FILE_SIZE" value="30000" />';
        $html .= '<input type="file" name ="image" accept="application.jpg"/>';
        $html .= '<input type=submit name="valider"/>';
        $html .='</form>';

        return $html;
    }

    public function render($selecteur){
        $app = Slim::getInstance();
        $content = "";
        switch ($selecteur) {
            case FORMULAIRE_List: {
                $content = $this->formulaireList();
                break;
            }
            case FORMULAIRE_ITEM: {
                $content = $this->formulaireItem();
                break;
            }
            case FORMUALIRE_List_INCORRECT: {
                $content = $this->formulaireListIncorrect();
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
