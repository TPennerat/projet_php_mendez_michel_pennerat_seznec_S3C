<?php

namespace mywishlist\vue;

use mywishlist\models\Item;
use mywishlist\models\Liste;
use Slim\Slim;
const FORMULAIRE_LISTE = 1;
const FORMULAIRE_ITEM = 2;
const FORMULAIRE_LISTE_INCORRECT = 3;
const FORMULAIRE_SUPPRESSION_LISTE = 4;
const FORMULAIRE_LISTE_PAS_CO = 5;
const FORMULAIRE_ITEM_PAS_CO = 6;
const MODIF_ITEM = 7;
const MODIF_LISTE= 8;

class VueFormulaire {
    public $arr;

    public function __construct($a){
        $this->arr=$a;
    }

    private function formulaireListeIncorrect(){
        $html="<div id=\"mainpage\"><h2>Création d'une liste</h2></div>";
        $html.='<div class="reste" align="center">';
        $urlCreerListe = Slim::getInstance()->urlFor('creerListe');
        $html .="<form id=\"f1\" method=\"post\" action=\"$urlCreerListe\">";
        $html .= '<p style="color: red">Nom de liste déjà existant</p>';
        $html .= '<input type="text" name="nomListe" required placeholder="Nom de la liste">';
        $html .= '<input type="text" name="descr" placeholder="Description">';
        $html .= '<label for="exp">Date d\'expiration :</label>
        <input type="date" id="exp" name="expListe" max="2050-01-01">
        <script>
        var ajd = new Date().toISOString().split(\'T\')[0];
        document.getElementsByName("expListe")[0].setAttribute(\'min\', ajd);
        </script>';
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
        $urlCreerListe = Slim::getInstance()->urlFor('creerListe');
        $html .="<form id=\"f1\" method=\"post\" action=\"$urlCreerListe\" enctype='multipart/form-data'>";
        $html .= 'Nom de liste : <input type="text" name="nomListe" required placeholder="Nom de la Liste">';
        $html .= 'Description : <input type="text" name="descr" placeholder="Description">';
        $html .= '<label for="exp">Date d\'expiration :</label>
        <input type="date" id="exp" name="expListe" required max="2050-01-01">
        <script>
        var ajd = new Date().toISOString().split(\'T\')[0];
        document.getElementsByName("expListe")[0].setAttribute(\'min\', ajd);
        </script>';
        $html .= '<label>'."Publique".'<input type="checkbox" name="'."Publique".'" id="'.'Publique'.'"></label><br>';

        foreach($this->arr as $i){
            $html .= '<div><p><label>'.$i['nom'].'<input type="checkbox" name="'.$i['id'].'" id="'.$i['id'].'"></label></p></div>';
        }
        $html .= '<br><button type=submit name="valider">Valider</button>';
        $html .='</form>';
        $html.='</div>';

        return $html;
    }

    private function formulaireModListe(){
        $l = Liste::find($this->arr['no']);
        $publique=$l['publique'];
        $nom=$l['titre'];
        $descr=$l['description'];
        $date=$l['expiration'];
        $html="<div id=\"mainpage\"><h2>Modification d'une Liste</h2></div>";
        $html.='<div class="reste" align="center">';
        $urlCreerListe = Slim::getInstance()->urlFor('modifierListe',['token'=>$this->arr['token'],'no'=>$this->arr['no']]);
        $html .="<form id=\"f7\" method=\"post\" action=\"$urlCreerListe\" enctype='multipart/form-data'>";
        $html .= "Nom de liste : <input type=\"text\" name=\"nomListe\"  value=\"$nom\">";
        $html .= "Description : <input type=\"text\" name=\"descr\" value=\"$descr\">";
        $html .= "<label for=\"exp\">Date d'expiration :</label>
        <input type=\"date\" id=\"exp\" name=\"expListe\" max=\"2050-01-01\" value=\"$date\">
        <script>
        var ajd = new Date().toISOString().split('T')[0];
        document.getElementsByName(\"expListe\")[0].setAttribute('min', ajd);
        </script>";
        if ($publique==0){
            $html .= '<label>'."Publique".'<input type="checkbox" name="'."Publique".'" id="'.'Publique'.'"></label><br>';
        } else {
            $html .= '<label>'."Privé".'<input type="checkbox" name="'."prive".'" id="'.'Publique'.'"></label><br>';
        }

        $html .="<p align='center'>Sélectionnez des items à supprimer</p>";
        foreach($l->items as $i){
            if ($i->pivot->reserve == 0) {
                $html .= '<div><p><label>' . $i['nom'] . '<input type="checkbox" name="' . $i['id'] . '" id="' . $i['id'] . '"></label></p></div>';
            }
        }
        $html .="<br><p align='center'>Sélectionnez des items à ajouter</p>";
        foreach (Item::all() as $item) {
            $ok=0;
            foreach ($l->items as $mesItems){
                if ($mesItems['id']==$item['id']) {
                    $ok=1;
                }
            }
            if ($ok==0) {
                $html .= '<div><p><label>' . $item['nom'] . '<input type="checkbox" name="' . $item['id'] . '" id="' . $item['id'] . '"></label></p></div>';
            }
        }
        $html .= '<br><button type=submit name="valider">Valider</button>';
        $html .='</form>';
        $html.='</div>';

        return $html;
    }

    private function formulaireListePasCo() {
        $html="<div id=\"mainpage\"><h2>Création d'une Liste</h2></div>";
        $html.='<div class="reste" align="center">';
        $urlCreerListe = Slim::getInstance()->urlFor('creerListe');
        $html .="<p>Vous devez vous connecter pour pouvoir créer une liste.</p>";

        return $html;
    }

    private function formulaireItem(){
        $html="<div id=\"mainpage\"><h2>Création d'un item</h2></div>";
        $html .='<div class="reste" align="center">';
        $urlCreerItem = Slim::getInstance()->urlFor('creerItem');
        $html .="<form id=\"f2\" method=\"post\" action=\"$urlCreerItem\" enctype=\"multipart/form-data\">";
        $html .= '<div>Nom : <input type="text" name="nomItem" required placeholder="Nom de l\'item"></div>';
        $html .= '<div>Description : <input type="text" name="descr" placeholder="Description"></div>';
        $html .= '<div>Liste à laquelle ajouter l\'item : <select name="select">';
        foreach($this->arr as $i){
            $html .= '<option value="'.$i['no'].'">'.$i['titre'].'</option>';
        }
        $html.='</select></div>';
        //$html .= '<input type="hidden" name="MAX_FILE_SIZE" value="30000">';
        $html .= '<div><input type="file" name="image"></div>';
        $html .= '<div>Tarif : <input type="text" name="tarif" placeholder="00" required></div>';
        $html .= '<br><button type=submit name="valider">Valider</button>';
        $html .='</form>';
        $html .='</div>';

        return $html;
    }

    private function formulaireItemPasCo() {
        $html="<div id=\"mainpage\"><h2>Création d'un item</h2></div>";
        $html .='<div class="reste" align="center">';
        $html .="<p>Vous devez vous connecter pour pouvoir créer un item.</p>";

        return $html;
    }

    private function formulaireSuppressionListe($token,$id){
        $l = Liste::find($id)->toArray();
        $titre = $l['titre'];
        $titre = strtolower($titre);
        $url = Slim::getInstance()->urlFor('racine');
        $urlSuppr = Slim::getInstance()->urlFor('supprimer',["token"=>$token,"id"=>$id]);
        $html = "<div align='center' style='background-color : #fff099'><p style='margin-top : 100px; padding-left : 0px;'>Voulez-vous vraiment supprimer la liste $titre ?</p>";
        $html .= "<form method='post' action='$urlSuppr' enctype='multipart/form-data'><input type='submit' value='oui' /></form>
    <a href='$url'><input type='submit' value='non' /></a></div>";
        return $html;
    }

    private function modifierItem(){
        $id= $this->arr['id'];
        $nom=$this->arr['nom'];
        $descr=$this->arr['descr'];
        $routeModif=Slim::getInstance()->urlFor('modifierItem',["id"=>$id]);
        $html="<div id=\"mainpage\"><h2>Modification de l'item $id</h2></div>";
        $html .='<div class="reste" align="center">';
        $html .="<form id=\"f2\" method=\"post\" action=\"$routeModif\" enctype=\"multipart/form-data\">";
        $html .= "<div>Nom de l'item : $nom</div>";
        $html .= "<div>Description : <input type=\"text\" name=\"descr\" placeholder=\"$descr\"></div>";
        $html .= "<div>Prix : <input type='text' name='tarif' placeholder='00' required></div>";
        //$html .= '<input type="hidden" name="MAX_FILE_SIZE" value="30000">';
        $html .= '<div><input type="file" name="image"></div>';
        $html .= '<br><button type=submit name="valider">Valider</button>';
        $html .='</form>';
        $html .='</div>';

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
            case FORMULAIRE_LISTE_INCORRECT: {
                $content = $this->formulaireListeIncorrect();
                break;
            }
            case FORMULAIRE_SUPPRESSION_LISTE: {
                $content = $this->formulaireSuppressionListe($this->arr[0],$this->arr[1]);
                break;
            }
            case FORMULAIRE_LISTE_PAS_CO: {
                $content = $this->formulaireListePasCo();
                break;
            }
            case FORMULAIRE_ITEM_PAS_CO: {
                $content = $this->formulaireItemPasCo();
                break;
            }
            case MODIF_ITEM: {
                $content = $this->modifierItem();
                break;
            }
            case MODIF_LISTE : {
                $content = $this->formulaireModListe();
                break;
            }
        }
        $urlRacine=$app->urlFor('racine');
        $urlCSS=$app->request->getRootURI().'/web/style.css';
        $urlFavicon = $app->request->getRootUri().'/web/favicon.png';
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
  <link REL="SHORTCUT ICON" href="$urlFavicon">
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
