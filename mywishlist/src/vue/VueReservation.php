<?php


namespace mywishlist\vue;

use mywishlist\models\Liste;
use Slim\Slim;
const AFFICHER_RESERVATION_ITEM = 0;
const REMERCIEMENT = 1;
const AFFICHER_RESERVATION_ITEM_INCORRECT = 2;

class VueReservation
{
    public $arr;

    public function __construct($a)
    {
        $this->arr = $a;
    }

    private function afficherReservItem(){
        $app = Slim::getInstance();
        $html = "<div id=\"mainpage\"><h2>Réserver cet item</h2></div><div id=\"reste\">";
        $urlReserv = $app->urlFor("reservOK",["id"=>$this->arr]);
        $log="";
        if (isset($_SESSION['id_connect'])){
            $log = $_SESSION['id_connect'];
        }
        $html .= <<<END
<div align="center"> <form id="formReserv" method="post" action="$urlReserv" enctype="multipart/form-data">
Réservé par : <input type="text" name="nomReserv" value="$log" placeholder="Nom de la personne" required/><br>
Votre message : <input type="text" name="messReserv" placeholder="Votre message mignon" /><br>
<input type="submit" />
</div>
END;

        $html.="</div>";
        return $html;
    }

    private function afficherReservItemIncorrect(){
        $app = Slim::getInstance();
        $html = "<div id=\"mainpage\"><h2>Réserver cet item</h2></div><div id=\"reste\">";
        $urlReserv = $app->urlFor("reservOK",["id"=>$this->arr['id']]);
        $log="";
        $mess=$this->arr['mess'];
        if (isset($_SESSION['id_connect'])){
            $log = $_SESSION['id_connect'];
        }
        $html .= <<<END
<div align="center">
<p style="color: red">$mess</p>
<form id="formReserv" method="post" action="$urlReserv" enctype="multipart/form-data">
Réservé par : <input type="text" name="nomReserv" value="$log" placeholder="Nom de la personne" required /><br>
Votre message : <input type="text" name="messReserv" placeholder="Votre message mignon" /><br>
<input type="submit" />
</div>
END;

        $html.="</div>";
        return $html;
    }

    private function remerciement(){
        $urlListe =  "";
        if (isset($_COOKIE['token_liste_reserv_pub'])) {
            $tok = Liste::find(unserialize($_COOKIE['token_liste_reserv_pub']))['tokenPartage'];
            $urlListe = Slim::getInstance()->urlFor("getListe",["token"=>$tok,"id"=>unserialize($_COOKIE['token_liste_reserv_pub'])]);
        }
        return <<<END
<div id=\"reste\">
<h2 style="color: #ab7933">
<a href="$urlListe">Votre réservation pour l'item à bien été prise en compte !</a>
</h2>
</div>
END;

    }

    public function render($selecteur)
    {
        $app = Slim::getInstance();
        $content = "";
        switch ($selecteur) {
            case AFFICHER_RESERVATION_ITEM:
            {
                $content = $this->afficherReservItem();
                break;
            }
            case REMERCIEMENT : {
                $content = $this->remerciement();
                break;
            }
            case AFFICHER_RESERVATION_ITEM_INCORRECT:{
                $content = $this->afficherReservItemIncorrect();
            }
        }
        $urlRacine = $app->urlFor('racine');
        $urlCSS = $app->request->getRootURI() . '/web/style.css';
        $urlFavicon = $app->request->getRootUri().'/web/favicon.png';
        $urlConnexion = $app->urlFor('connexion');
        $urlInscription = $app->urlFor('inscription');
        $urlDeconnexion = $app->urlFor('deconnexion');
        if (isset($_SESSION['id_connect'])) {
            $hautDroite = "<span><form id='deco' method='post' action=\"$urlDeconnexion\"><button type=submit name='valider'>Se deconnecter</button></form></span>";
        } else {
            $hautDroite = "<span><a id=\"conn\" href=\"$urlInscription\">Inscription</a></span>";
            $hautDroite .= "<span><a id=\"conn\" href=\"$urlConnexion\">Connexion</a></span>";
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
