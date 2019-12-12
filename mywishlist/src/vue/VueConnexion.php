<?php

namespace mywishlist\vue;

const INTERFACE_CONNEXION = 1;

class VueConnexion {
    public $arr;

    public function __construct($a){
        $this->arr=$a;
    }

    private function afficherIntefaceConnexion(){
        $app = \Slim\Slim::getInstance();
        $html=<<<END
<div align="center" class="connect">
    <form id="f2" method="post" action="seConnecter" enctypr="multipart/form-data">
        <p>Identifiant</p><input type="text" name="identifiant" required placeholder="Identifiant">
        <br>
        <p>Mot de passe</p><input type="text" name="mdp" required placeholder="Mot de passe">
        <br>
        <br>
        <button type=submit name="valider">Se Connecter</button>
    </form>
</div>
END;

        return $html;
    }

    private function racine(){
        $app = \Slim\Slim::getInstance();
        $html = "<h2>Accueil</h2>" ;
        $html .= 'Accès aux listes : <a href="'.$app->urlFor('getListes').'">listes</a><br>';
        $html .= 'Ajout d\'une liste : <a href="'.$app->urlFor('creerListe').'">liste</a><br>';
        $html .= 'Ajout d\'un item : <a href="'.$app->urlFor('creerItem').'">item</a><br>';

        return $html;
    }

    public function render($selecteur){
        $app = \Slim\Slim::getInstance();
        switch ($selecteur) {
            case INTERFACE_CONNEXION: {
                $content = $this->afficherIntefaceConnexion();
                break;
            }
        }
        $urlRacine=$app->urlFor('racine');
        $urlCSS=$app->request->getRootURI().'/web/style.css';
        $html = <<<END
<!DOCTYPE html>
<html>
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
<html>
END;
        echo $html;
    }

}