<?php


namespace mywishlist\vue;

use mywishlist\models\Liste;
use Slim\Slim;
const AFFICHER_RESERVATION_ITEM = 0;
const REMERCIEMENT = 1;

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
        $URI = Slim::getInstance()->request->getRootURI();
        $urlReserv = $app->urlFor("reservOK",$this->arr);
        $html .= <<<END
<div align="center"> <form id="formReserv" method="post" action="$urlReserv" enctype="multipart/form-data">
Reservé par : <input type="text" name="nomReserv" placeholder="Nom de la personne" />
<input type="submit" />
</div>
END;

        $html.="</div>";
        return $html;
    }

    private function remerciement(){
        return <<<END
<div id=\"mainpage\"><h2>Réserver cet item</h2></div><div id=\"reste\">
<h2>
Votre réservation à bien été prise en compte !
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
            }
        }
        $urlRacine = $app->urlFor('racine');
        $urlCSS = $app->request->getRootURI() . '/web/style.css';
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
