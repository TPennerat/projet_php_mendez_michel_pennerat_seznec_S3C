<?php

namespace mywishlist\vue;

use mywishlist\models\Liste;
use Slim\Slim;
const FORMULAIRE_LISTE = 1;
const FORMULAIRE_ITEM = 2;
const FORMUALIRE_LISTE_INCORRECT = 3;
const FORMULAIRE_SUPPRESSION_LISTE = 4;

class VueFormulaire {
    public $arr;

    public function __construct($a){
        $this->arr=$a;
    }

    private function formulaireListeIncorrect(){
        $html="<div id=\"mainpage\"><h2>Création d'une liste</h2></div>";
        $html.='<div class="reste" align="center">';
        $html .='<form id="f1" method="post" action="creerListe">';
        $html .= '<p style="color: red">Nom de liste déjà existant</p>';
        $html .= '<input type="text" name="nomListe" required placeholder="Nom de la liste">';
        $html .= '<input type="text" name="descr" placeholder="Description">';
        $html .= '<label>'."Publique".'<input type="checkbox" name="'."Publique".'" id="'.'Publique'.'"></label><br>';
        foreach($this->arr as $i){
            $html .= '<div><p><label>'.$i['nom'].'<input type="checkbox" name="'.$i['id'].'" id="'.$i['id'].'"></label></p></div>';
        }
        $html .= '<br><button type=submit name="valider">Valider</button>';
        $html .='</form>';
        $html.='</div>';

        return $html;
    }

    private function formulaireListe(){
        $html="<div id=\"mainpage\"><h2>Création d'une Liste</h2></div>";
        $html.='<div class="reste" align="center">';
        $html .='<form id="f1" method="post" action="creerListe">';
        $html .= '<input type="text" name="nomListe" required placeholder="Nom de la Liste">';
        $html .= '<input type="text" name="descr" placeholder="Description">';
        $html .= '<label>'."Publique".'<input type="checkbox" name="'."Publique".'" id="'.'Publique'.'"></label><br>';
        foreach($this->arr as $i){
            $html .= '<div><p><label>'.$i['nom'].'<input type="checkbox" name="'.$i['id'].'" id="'.$i['id'].'"></label></p></div>';
        }
        $html .= '<br><button type=submit name="valider">Valider</button>';
        $html .='</form>';
        $html.='</div>';

        return $html;
    }

    private function formulaireItem(){
        $html="<div id=\"mainpage\"><h2>Création d'un item</h2></div>";
        $html .='<div class="reste" align="center">';
        $html .='<form id="f2" method="post" action="creerItem" enctype="multipart/form-data">';
        $html .= '<div><input type="text" name="nomItem" required placeholder="Nom de l\'item"></div>';
        $html .= '<div><input type="text" name="descr" placeholder="Description"></div>';
        $html .= '<div><select name="select">';
        foreach($this->arr as $i){
            $html .= '<option value="'.$i['no'].'">'.$i['no']." ".$i['titre'].'</option>';
        }
        $html.='</select></div>';
        //$html .= '<input type="hidden" name="MAX_FILE_SIZE" value="30000">';
        $html .= '<div><input type="file" name="image"></div>';
        $html .= '<br><button type=submit name="valider">Valider</button>';
        $html .='</form>';
        $html .='</div>';

        return $html;
    }

    private function formulaireSuppressionListe($token,$id){
        $l = Liste::find($id)->toArray();
        $titre = $l['titre'];
        $titre = strtolower($titre);
        $url = Slim::getInstance()->urlFor('racine');
        $urlSuppr = Slim::getInstance()->urlFor('supprimer',["token"=>$token,"id"=>$id]);
        $html = "<div align='center' style='background-color : #fff099'>Voulez vraiment supprimer la liste $titre ?";
        $html .= "<form method='post' action='$urlSuppr' enctype='multipart/form-data'><input type='submit' value='oui' /></form>
    <a href='$url'><input type='submit' value='non' /></a></div>";
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
            case FORMULAIRE_SUPPRESSION_LISTE: {
                $content = $this->formulaireSuppressionListe($this->arr[0],$this->arr[1]);
                break;
            }
        }
        $urlRacine=$app->urlFor('racine');
        $urlCSS=$app->request->getRootURI().'/web/style.css';
        $urlConnexion=$app->urlFor('connexion');
        $urlInscription=$app->urlFor('inscription');
        $urlDeconnexion = $app->urlFor('deconnexion');
        if(isset($_SESSION['id_connect'])){
            $hautDroite="<span><form id='deco' method='post' action=\"$urlDeconnexion\"><button type=submit name='valider'>Se deconnecter</button></form></span>";
        }else{
            $hautDroite="<span><a id=\"conn\" href=\"$urlInscription\">Inscription</a></span>";
            $hautDroite.="<span><a id=\"conn\" href=\"$urlConnexion\">Connexion</a></span>";
        }
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
    $hautDroite
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
