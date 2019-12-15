<?php

namespace mywishlist\controleur;

use mywishlist\models\Compte;
use mywishlist\vue\VueConnexion;
use mywishlist\vue\VueFormulaire;
use Slim\Slim;
use const mywishlist\vue\FORMUALIRE_LISTE_INCORRECT;
use const mywishlist\vue\INTERFACE_CONNEXION;
use const mywishlist\vue\INTERFACE_MAUVAISE_COMBINAISON;

class ControleurConnexion{


    public function afficherInterfaceConnexion(){
        $vue= new VueConnexion(null);
        $vue->render(INTERFACE_CONNEXION);
    }

    public function seConnecter(){
        $this->creerUser("admin","admin");
        $app= Slim::getInstance();
        if (isset($_POST['identifiant']) && isset($_POST['mdp'])) {
            $id=filter_var($_POST['identifiant'],FILTER_SANITIZE_STRING);
            $mdp=filter_var($_POST['mdp'],FILTER_SANITIZE_STRING);
            $login=Compte::select("login")->where('login','=',"$id")->count();
            if($login==1 and password_verify($mdp,Compte::select("password")->where('login','=',"$id")->get()->toArray()[0]["password"])){
                $app->redirect($app->request->getRootUri());
            } else {
                $vue = new VueConnexion(null);
                $vue->render(INTERFACE_MAUVAISE_COMBINAISON);
            }
        }

    }

    public function creerUser($login,$mdp){
        if (Compte::select("login")->where('login','=',"$login")->count()==0) {
            $compte = new Compte();
            $compte->login = $login;
            $hash = password_hash($mdp, PASSWORD_DEFAULT, ['cost' => 12]);
            $compte->password = $hash;
            $compte->save();
        }
    }
}
