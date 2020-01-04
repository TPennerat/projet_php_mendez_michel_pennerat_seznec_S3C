<?php

namespace mywishlist\vue;

use mywishlist\models\Liste;
use Slim\Slim;
const AFFICHER_LISTES = 1;
const AFFICHER_LISTE = 2;
const AFFICHER_ITEM = 3;
const AFFICHER_RACINE = 4;
const BAD_TOKEN = 5;

class VueParticipant {
    public $arr;

    public function __construct($a){
        $this->arr=$a;
    }

    private function afficherLesListes(){
        $app= Slim::getInstance();
        $content="<div id=\"mainpage\"><h2>Listes</h2></div><div id=\"reste\"><p>Mes listes :</p>";
        foreach($this->arr as $l){
            if(isset($_SESSION['id_connect']) and $l->createur==$_SESSION['id_connect']){
                $content.="<li>".' <a href="'.$app->urlFor('getListe', ['token'=>$l['token'], 'id'=>$l["no"]]).'">'.$l["titre"]."</a></li>";
            }
        }
        $content.="<br><p>Listes publiques :</p>";
        foreach($this->arr as $l){
            if($l->publique==1){
                $content.="<li>".' <a href="'.$app->urlFor('getListe', ['token'=>$l['token'], 'id'=>$l["no"]]).'">'.$l["titre"]."</a></li>";
            }
        }

        $content.="</div>";

        return <<<END
    <section>$content</section>
END;
    }

    private function afficherListe($liste){
        $app = Slim::getInstance();
        $html = "<div id=\"mainpage\"><h2>Liste</h2></div><div id=\"reste\" style=\"position : relative;\"><div class=\"liste\">";
        $l = Liste::find($liste["no"]);
        $html .= "<h3>".$l->titre."</h3>";
        $html .= "<p>".$l->description."<p>";
        $items=$l->items()->get();
        $URI = Slim::getInstance()->request->getRootURI();
        foreach ($items as $item) {
            $html .= '<div>';
            $html .= "<img src=\"$URI/web/img/{$item->img}\" width=\"60\" height=\"60\" alt=\"{$item->descr}\">";
            $html .= '<a href="'.$app->urlFor('getItem', ['id'=>$item["id"]]).'">'.$item->nom.'</a>';
            $html .= '</div>';
        }
        if ($l->publique==0 or (isset($_SESSION['id_connect']) and $l->createur==$_SESSION['id_connect']))
            $html.='<p id="suppr" align=\'center\' style=\'color: red\'><a href="'.$app->urlFor("suppression",["token"=>$l->token,"id"=>$l->no]).'">Supprimer cette liste !</a></p>';
        $html.="</div></div>";
        return $html;
    }

    private function afficherItem($item){
        $url = Slim::getInstance()->request->getPath();
        $url = explode("/",$url);
        setcookie("token_liste_reserv",$url[sizeof($url)-2]);
        $html="<div id=\"mainpage\"><h2>Item</h2></div><div id=\"reste\"><div class=\"liste\">";
        $nomitem=$item["img"];
        $URI = Slim::getInstance()->request->getRootURI();
        $descr=$item["descr"];
        $html .= "<img id='itemimg' src=\"$URI/web/img/$nomitem\" width=\"60\" height=\"60\" alt=\"$descr\">";
        $html .= '<h3>'.$item["nom"].'</h3>';
        $html .= '<p>'.$item["descr"].'</p>';
        $urlReserv = Slim::getInstance()->urlFor('reserv',["id"=>$item["id"]]);
        $html .= "<p align='center'><a href=\"$urlReserv\">Réserver cet item ?</a></p>";
        $html .= "</div></div>";

        return $html;
    }

    private function racine(){
        $app = Slim::getInstance();

        $html = "<div id=\"mainpage\"><h2>Bienvenue sur MyWishList !</h2></div>" ;
        $html .= '<div class="reste"><div id="choix"><a href="'.$app->urlFor('getListes').'">Accès aux Listes</a>';
        $html .= '<a href="'.$app->urlFor('creerListe').'">Ajout d\'une Liste</a>';
        $html .= '<a href="'.$app->urlFor('creerItem').'">Ajout d\'un item</a></div></div>';

        return $html;
    }

    private function erreur_token(){
        return '<h2 style="color:red">Mauvais token : cette liste n\'est pas publique</h2>'; //DEBUG style dans le HTML
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
            case BAD_TOKEN : {
                $content = $this->erreur_token();
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
