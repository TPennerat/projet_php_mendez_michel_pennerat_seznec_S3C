<?php

namespace mywishlist\vue;

use Slim\Slim;
const INTERFACE_CONNEXION = 1;
const INTERFACE_MAUVAISE_COMBINAISON = 2;
const INTERFACE_INSCRIPTION = 3;
const INTERFACE_MAUVAISE_INSCRIPTION = 4;

class VueConnexion {
    public $arr;

    public function __construct($a){
        $this->arr=$a;
    }

    private function afficherInterfaceInscription(){
        return <<<END
<div align="center" class="connect">
    <form id="f3" method="post" action="inscription" enctype="multipart/form-data">
        <p>Identifiant</p><input type="text" name="identifiant" required placeholder="Identifiant">
        <br>
        <p>Mot de passe</p><input type="password" name="mdp" required placeholder="Mot de passe">
        <p>Confirmer mot de passe</p><input type="password" name="mdpconf" required placeholder="Mot de passe">
        <br>
        <br>
        <button type=submit name="valider">S'inscrire</button>
    </form>
</div>
END;
    }

    private function afficherInterfaceMauvaiseInscription(){
        return <<<END
<div align="center" class="connect">
    <p style='color : red'>$this->arr</p>
    <form id="f3" method="post" action="inscription" enctype="multipart/form-data">
        <p>Identifiant</p><input type="text" name="identifiant" required placeholder="Identifiant">
        <br>
        <p>Mot de passe</p><input type="password" name="mdp" required placeholder="Mot de passe">
        <p>Confirmer mot de passe</p><input type="password" name="mdpconf" required placeholder="Mot de passe">
        <br>
        <br>
        <button type=submit name="valider">S'inscrire</button>
    </form>
</div>
END;
    }

    private function afficherInterfaceConnexion(){
        $app=Slim::getInstance();
        $urlInscription = $app->urlFor('inscription');
        return <<<END
<div align="center" class="connect">
    <form id="f2" method="post" action="connexion" enctype="multipart/form-data">
        <p>Identifiant</p><input type="text" name="identifiant" required placeholder="Identifiant">
        <br>
        <p>Mot de passe</p><input type="password" name="mdp" required placeholder="Mot de passe">
        <p><a href="$urlInscription">Pas de compte ? S'inscrire</a></p>
        <br>
        <button type=submit name="valider">Se Connecter</button>
    </form>
</div>
END;
    }

    private function afficherInterfaceMauvaiseConnexion()
    {
        $app = Slim::getInstance();
        $urlInscription = $app->urlFor('inscription');
        return <<<END
<div align="center" class="connect">
    <form id="f2" method="post" action="connexion" enctype="multipart/form-data">
        <p style='color : red'>Mauvais login/mot de passe</p>
        <p>Identifiant</p><input type="text" name="identifiant" required placeholder="Identifiant">
        <br>
        <p>Mot de passe</p><input type="password" name="mdp" required placeholder="Mot de passe">
        <p><a href="$urlInscription">Pas de compte ? S'inscrire</a></p>
        <br>
        <button type=submit name="valider">Se Connecter</button>
    </form>
</div>
END;
    }

    private function afficherInterfaceDeconnexion(){
      $app = Slim::getInstance();
      return <<<END
<div align="center" class="connect">
  <form id="f3" method="post" action="deconnexion">
      <button type=submit name="valider">Se deconnecter</button>
  </form>
</div>
END;
    }

    public function render($selecteur){
        $app = Slim::getInstance();
        $content = "";
        switch ($selecteur) {
            case INTERFACE_CONNEXION:
            {
                $content = $this->afficherInterfaceConnexion();
                break;
            }
            case INTERFACE_MAUVAISE_COMBINAISON : {
                $content = $this->afficherInterfaceMauvaiseConnexion();
                break;
            }
            case INTERFACE_INSCRIPTION : {
                $content = $this->afficherInterfaceInscription();
                break;
            }
            case INTERFACE_MAUVAISE_INSCRIPTION : {
                $content = $this->afficherInterfaceMauvaiseInscription();
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
