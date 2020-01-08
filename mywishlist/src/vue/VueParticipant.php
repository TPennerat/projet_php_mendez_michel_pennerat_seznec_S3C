<?php

namespace mywishlist\vue;

use mywishlist\models\Liste;
use Slim\Slim;
const AFFICHER_LISTES = 1;
const AFFICHER_LISTE = 2;
const AFFICHER_ITEM = 3;
const AFFICHER_RACINE = 4;
const AFFICHER_LISTE_NO_CO =6;
const AFFICHER_LISTE_PARTAGE = 7;
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
                $content.="<li>".' <a href="'.$app->urlFor('getListePartage', ['tokenPartage'=>$l['tokenPartage'], 'id'=>$l["no"]]).'">'.$l["titre"]."</a></li>";
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
        if ($l->publique==0 or (isset($_SESSION['id_connect']) and $l->createur==$_SESSION['id_connect'])){
            $html.="<p align='center' style=\'color: red\'>Url de partage : localhost$URI/afficherListePartage/$l->tokenPartage/$l->no</p>";
            $html.='<p id="suppr" align=\'center\' style=\'color: red\'><a href="'.$app->urlFor("suppression",["token"=>$l->token,"id"=>$l->no]).'">Supprimer cette liste !</a></p>';
        }
        $messages = $l->messages()->get();
        foreach ($messages as $message) {
          $html.='<p>'."$message->login : $message->message".'</p>';
        }

        $html .='</div><div align="center">';
        $urlAjouterMessage = Slim::getInstance()->urlFor('ajouterMessage',["token"=>$liste->token,"id"=>$liste->no]);
        $html .="<form method=\"post\" action=\"$urlAjouterMessage\" enctype=\"multipart/form-data\">";
        $html .= '<div><input type="text" name="message" required placeholder="Message"></div>';
        $html .= '<br><button type=submit name="valider">Envoyer</button>';

        $html.="</div>";


        return $html;
    }

    private function afficherItem($item){
        $html="<div id=\"mainpage\"><h2>Item</h2></div><div id=\"reste\"><div class=\"liste\">";
        $nomitem=$item["img"];
        $URI = Slim::getInstance()->request->getRootURI();
        $descr=$item["descr"];
        $html .= "<img id='itemimg' src=\"$URI/web/img/$nomitem\" width=\"60\" height=\"60\" alt=\"$descr\">";
        $html .= '<h3>'.$item["nom"].'</h3>';
        $html .= '<p>'.$item["descr"].'</p>';
        $l = Liste::find(unserialize($_COOKIE['token_liste_reserv']));
        $login=null;
        foreach ($l->items as $log) {
            if ($log['id']==$item['id']){
                $login = $log->pivot->loginReserv;
            }
        }
        if (!isset($_SESSION['id_connect']) or($login == null and $l['createur']!=$_SESSION['id_connect'])) {
            $urlReserv = Slim::getInstance()->urlFor('reserv',["id"=>$item["id"]]);
            $urlCagnotte= Slim::getInstance()->urlFor('Cagnotte',["id"=>$item["id"]]);
            $html .= "<p align='center'><a href=\"$urlReserv\">Réserver cet item ?</a></p>";
            $html .= "<p align='center'><a href=\"$urlCagnotte\">Créer une cagnotte pour l'item?</a></p>";
        } else if (isset($_COOKIE['nomUser']) and ($l['createur']!=$_SESSION['id_connect'] or $_COOKIE['nomUser']==$l['createur'])) {
            $html .= "<p align='center'>Réservé par $login</p>";
        }
        $html .= "</div></div>";

        return $html;
    }

    private function afficherListePasCo($liste){
        $app = Slim::getInstance();
        $html = "<div id=\"mainpage\"><h2>Liste</h2></div><div id=\"reste\" style=\"position : relative;\"><div class=\"liste\">";
        $l = Liste::find($liste["no"]);
        $html.="<p style='color: red'>Veuillez-vous connecter pour poster un message</p>";
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

        $messages = $l->messages()->get();
        foreach ($messages as $message) {
            $html.='<p>'."$message->login : $message->message".'</p>';
        }

        $html .='</div><div align="center">';
        $urlAjouterMessage = Slim::getInstance()->urlFor('ajouterMessage',["token"=>$liste->token,"id"=>$liste->no]);
        $html .="<form method=\"post\" action=\"$urlAjouterMessage\" enctype=\"multipart/form-data\">";
        $html .= '<div><input type="text" name="message" required placeholder="Message"></div>';
        $html .= '<br><button type=submit name="valider">Envoyer</button>';

        $html.="</div>";


        return $html;
    }

    private function afficherListePartage($liste){
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
        $messages = $l->messages()->get();
        foreach ($messages as $message) {
          $html.='<p>'."$message->login : $message->message".'</p>';
        }

        $html .='</div><div align="center">';
        $urlAjouterMessage = Slim::getInstance()->urlFor('ajouterMessage',["token"=>$liste->token,"id"=>$liste->no]);
        $html .="<form method=\"post\" action=\"$urlAjouterMessage\" enctype=\"multipart/form-data\">";
        $html .= '<div><input type="text" name="message" required placeholder="Message"></div>';
        $html .= '<br><button type=submit name="valider">Envoyer</button>';

        $html.="</div>";


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
            case AFFICHER_LISTE_PARTAGE : {
                $content = $this->afficherListePartage($this->arr[0]);
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
            case AFFICHER_LISTE_NO_CO : {
                $content = $this->afficherListePasCo($this->arr);
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
