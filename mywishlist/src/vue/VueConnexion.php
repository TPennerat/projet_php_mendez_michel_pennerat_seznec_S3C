<?php

namespace mywishlist\vue;

use Slim\Slim;
const INTERFACE_CONNEXION = 1;
const INTERFACE_MAUVAISE_COMBINAISON = 2;
const INTERFACE_INSCRIPTION = 3;
const INTERFACE_MAUVAISE_INSCRIPTION = 4;
const INTERFACE_CHANGEMENT_MDP = 5;
const INTERFACE_CHANGEMENT_MDP_INCORRECT_LOGIN = 6;
const INTERFACE_CHANGEMENT_MDP_INCORRECT_MDP = 7;

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
        $urlModifMdp = $app->urlFor('modifmdp');
        $user ="";
        if (isset($_COOKIE['nomUser'])){
            $user = base64_decode($_COOKIE['nomUser']);
        }
        return <<<END
<div align="center" class="connect">
    <form id="f2" method="post" action="connexion" enctype="multipart/form-data">
        <p>Identifiant</p><input type="text" name="identifiant" value="$user" required placeholder="Identifiant">
        <br>
        <p>Mot de passe</p><input type="password" name="mdp" required placeholder="Mot de passe">
        <br><br>Se souvenir de moi<input type="checkbox" name="ssdm" />
        <p><a href="$urlInscription">Pas de compte ? S'inscrire</a></p>
        <p><a href="$urlModifMdp">Mot de passe oublié ?</a></p>
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
        $urlModifMdp = $app->urlFor('modifmdp');
        $user ="";
        if (isset($_COOKIE['nomUser'])){
            $user = base64_decode($_COOKIE['nomUser']);
        }
        return <<<END
<div align="center" class="connect">
    <form id="f2" method="post" action="connexion" enctype="multipart/form-data">
        <p style='color : red'>Mauvais login/mot de passe</p>
        <p>Identifiant</p><input type="text" name="identifiant" value="$user" required placeholder="Identifiant">
        <br>
        <p>Mot de passe</p><input type="password" name="mdp" required placeholder="Mot de passe">
        <br><br>Se souvenir de moi<input type="checkbox" name="ssdm" />
        <p><a href="$urlInscription">Pas de compte ? S'inscrire</a></p>
        <p><a href="$urlModifMdp">Mot de passe oublié ?</a></p>
        <br>
        <button type=submit name="valider">Se Connecter</button>
    </form>
</div>
END;
    }

    private function afficherInterfaceMotDePasse()
    {
        $app = Slim::getInstance();
        $urlInscription = $app->urlFor('inscription');
        $urlModif =$app->urlFor('modifMDPOk');
        return <<<END
<div align="center" class="connect">
    <form id="f5" method="post" action="$urlModif" enctype="multipart/form-data">
        <p>Identifiant</p><input type="text" name="identifiant" required placeholder="Identifiant">
        <br>
        <p>Nouveau mot de passe</p><input type="password" name="mdp" required placeholder="Mot de passe">
        <p>Confirmer nouveau mot de passe</p><input type="password" name="mdpconf" required placeholder="Mot de passe">
        <p><a href="$urlInscription">Pas de compte ? S'inscrire</a></p>
        <br>
        <button type=submit name="valider">Changer le mot de passe</button>
    </form>
</div>
END;
    }

    private function afficherInterfaceMotDePasseIncorrectLogin()
    {
        $app = Slim::getInstance();
        $urlInscription = $app->urlFor('inscription');
        $urlModif =$app->urlFor('modifMDPOk');
        return <<<END
<div align="center" class="connect">
    <form id="f5" method="post" action="$urlModif" enctype="multipart/form-data">
    <p style='color : red'>Login inconnu</p>
        <p>Identifiant</p><input type="text" name="identifiant" required placeholder="Identifiant">
        <br>
        <p>Nouveau mot de passe</p><input type="password" name="mdp" required placeholder="Mot de passe">
        <p>Confirmer nouveau mot de passe</p><input type="password" name="mdpconf" required placeholder="Mot de passe">
        <p><a href="$urlInscription">Pas de compte ? S'inscrire</a></p>
        <br>
        <button type=submit name="valider">Changer le mot de passe</button>
    </form>
</div>
END;
    }

    private function afficherInterfaceMotDePasseIncorrectMDP()
    {
        $app = Slim::getInstance();
        $urlInscription = $app->urlFor('inscription');
        $urlModif =$app->urlFor('modifMDPOk');
        return <<<END
<div align="center" class="connect">
    <form id="f5" method="post" action="$urlModif" enctype="multipart/form-data">
    <p style='color : red'>Les mots de passes sont différents</p>
        <p>Identifiant</p><input type="text" name="identifiant" required placeholder="Identifiant">
        <br>
        <p>Nouveau mot de passe</p><input type="password" name="mdp" required placeholder="Mot de passe">
        <p>Confirmer nouveau mot de passe</p><input type="password" name="mdpconf" required placeholder="Mot de passe">
        <p><a href="$urlInscription">Pas de compte ? S'inscrire</a></p>
        <br>
        <button type=submit name="valider">Changer le mot de passe</button>
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
            case INTERFACE_CHANGEMENT_MDP : {
                $content = $this->afficherInterfaceMotDePasse();
                break;
            }
            case INTERFACE_CHANGEMENT_MDP_INCORRECT_LOGIN : {
                $content = $this->afficherInterfaceMotDePasseIncorrectLogin();
                break;
            }
            case INTERFACE_CHANGEMENT_MDP_INCORRECT_MDP: {
                $content = $this->afficherInterfaceMotDePasseIncorrectMDP();
                break;
            }
        }
        $urlRacine=$app->urlFor('racine');
        $urlCSS=$app->request->getRootURI().'/web/style.css';
        $urlFavicon = $app->request->getRootUri().'/web/favicon.png';
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
