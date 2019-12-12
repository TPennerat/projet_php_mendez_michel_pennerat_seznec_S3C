<?php

namespace mywishlist\controleur;

use mywishlist\vue\VueConnexion;
use Slim\Slim;
use const mywishlist\vue\INTERFACE_CONNEXION;

class ControleurConnexion{

    public function afficherInterfaceConnexion(){
        $vue= new VueConnexion(null);
        $vue->render(INTERFACE_CONNEXION);
    }

    public function seConnecter(){
        $app= Slim::getInstance();
        if (isset($_POST['identifiant']) && isset($_POST['mdp'])) {
            // vérif avec bdd si utilisateur connu
            $id=filter_var($_POST['identifiant'],FILTER_SANITIZE_STRING);
            $mdp=filter_var($_POST['mdp'],FILTER_SANITIZE_STRING);//a decripter avec le bon encodage...
            $app->redirect($app->request->getRootUri());
        }

    }
}
