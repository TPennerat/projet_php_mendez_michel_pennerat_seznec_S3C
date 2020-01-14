<?php


namespace mywishlist\vue;

use mywishlist\models\Liste;
use Slim\Slim;
const AFFICHER_CREER_CAGNOTTE_ITEM = 0;
const AFFICHER_CAGNOTTE_ITEM = 1;
const AFFICHER_CAGNOTTE_ITEM_INCORRECT = 2;
const AFFICHER_ITEM_RESERVE = 3;
const AFFICHER_CAGNOTTE_ITEM_FINI = 4;

use mywishlist\models\Item;

class VueCagnotte{
    public $arr;

    public function __construct($a)
    {
        $this->arr = $a;
    }

    private function afficherCreationCagnotte(){
        $app = Slim::getInstance();
        $html = "<div id=\"mainpage\"><h2>Cagnotte de l'item</h2></div><div id=\"reste\">";
        $urlCreation = $app->urlFor("creerCagnotte",["id"=>$this->arr]);
        $log="";
        if (isset($_SESSION['id_connect'])){
            $log = $_SESSION['id_connect'];
        }
        $html .= <<<END
<div align="center"> <form id="formCagnotte" method="post" action="$urlCreation" enctype="multipart/form-data">
Voulez-vous créer une cagnotte pour cet item? La réservation deviendra impossible.
<input name="Créer cagnotte" type="submit"/>
</div>
END;

        $html.="</div>";
        return $html;
    }

    private function afficherCagnotteItem(){
        $app = Slim::getInstance();
        $html = "<div id=\"mainpage\"><h2>Cagnotte de l'item</h2></div><div id=\"reste\">";
        $urlModif = $app->urlFor("monterCagnotte",["id"=>$this->arr]);
        $log="";
        if (isset($_SESSION['id_connect'])){
            $log = $_SESSION['id_connect'];
        }
        $id = $this->arr;
        $liste = Liste::find(unserialize($_COOKIE['token_liste_reserv']));
        foreach ($liste->items as $i) {
            if ($i['id']==$id){
                $val = $i->pivot->valCagnotte;
            }
        }
        $tarif = Item::find($id)->tarif;
        $html .= <<<END
<div align="center"> <form id="formCagnotte" method="post" action="$urlModif" enctype="multipart/form-data">
<h2>Etat de la cagnotte : $val / $tarif</h2>
<p>Combien voulez-vous ajouter à la cagnotte?</p>
<input type="number" step="0.01" name="val" required placeholder="Valeur">
<input name="Ajouter" type="submit" />
</div>
END;

        $html.="</div>";
        return $html;
    }

    private function afficherErreur(){
        $html = $this->afficherCagnotteItem();

        $html.='<div align="center" style="color:red">Valeur incorrecte, la valeur de la cagnotte ne doit pas excéder le tarif de l\'objet</div>';
        return $html;
    }

    private function afficherErreurItemReserve(){
        return '<div align="center" style="color:red">Création de la cagnotte impossible : cet item est réservé </div>';
    }

    private function afficherCagnotteFinie(){
        $app = Slim::getInstance();
        $html = "<div id=\"mainpage\"><h2>Cagnotte de l'item</h2></div><div id=\"reste\">";
        $log="";
        if (isset($_SESSION['id_connect'])){
            $log = $_SESSION['id_connect'];
        }
        $id = $this->arr;
        $liste = Liste::find(unserialize($_COOKIE['token_liste_reserv']));
        foreach ($liste->items as $i) {
            if ($i['id']==$id){
                $val = $i->pivot->valCagnotte;
            }
        }
        $tarif = Item::find($id)->tarif;

        $html .= <<<END
<div align="center">
<h2>Etat de la cagnotte : $val / $tarif</h2>
<p>La cagnotte est complétée, merci à tous!</p>
</div>
END;

        $html.="</div>";
        return $html;
    }

    public function render($selecteur){
        $app = Slim::getInstance();
        $content = "";
        switch ($selecteur) {
            case AFFICHER_CREER_CAGNOTTE_ITEM:
            {
                $content = $this->afficherCreationCagnotte();
                break;
            }
            case AFFICHER_CAGNOTTE_ITEM:
            {
                $content = $this->afficherCagnotteItem();
                break;
            }
            case AFFICHER_CAGNOTTE_ITEM_INCORRECT:{
                $content = $this->afficherErreur();
                break;
            }
            case AFFICHER_ITEM_RESERVE:{
                $content = $this->afficherErreurItemReserve();
                break;
            }
            case AFFICHER_CAGNOTTE_ITEM_FINI:
            {
                $content = $this->afficherCagnotteFinie();
                break;
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
