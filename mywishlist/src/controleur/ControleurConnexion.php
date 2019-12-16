<?php

namespace mywishlist\controleur;

use mywishlist\models\Account;
use mywishlist\vue\VueConnexion;
use Slim\Slim;
use const mywishlist\vue\INTERFACE_CONNEXION;
use const mywishlist\vue\INTERFACE_INSCRIPTION;
use const mywishlist\vue\INTERFACE_MAUVAISE_COMBINAISON;
use const mywishlist\vue\INTERFACE_MAUVAISE_INSCRIPTION;

class ControleurConnexion{

    public function afficherInterfaceConnexion(){
        $vue= new VueConnexion(null);
        $vue->render(INTERFACE_CONNEXION);
    }

    public function afficherInterfaceInscription(){
        $vue= new VueConnexion(null);
        $vue->render(INTERFACE_INSCRIPTION);
    }

    public function sInscrire(){
        $app= Slim::getInstance();
        if (isset($_POST['identifiant']) && isset($_POST['mdp'])) {
            $id=filter_var($_POST['identifiant'],FILTER_SANITIZE_STRING);
            $mdp=filter_var($_POST['mdp'],FILTER_SANITIZE_STRING);
            $login=Account::select("login")->where('login','=',"$id")->count();
            if($login==0){
                if ($mdp==filter_var($_POST['mdpconf'],FILTER_SANITIZE_STRING)) {
                    $this->creerUser($id,$mdp);
                    $app->redirect($app->request->getRootUri());
                } else {
                    $vue = new VueConnexion("Mot de passe incorrect");
                    $vue->render(INTERFACE_MAUVAISE_INSCRIPTION);
                }
            } else {
                $vue = new VueConnexion("Login déjà utilisé");
                $vue->render(INTERFACE_MAUVAISE_INSCRIPTION);
            }
        }

    }

    public function seConnecter(){
        $app= Slim::getInstance();
        if (isset($_POST['identifiant']) && isset($_POST['mdp'])) {
            $id=filter_var($_POST['identifiant'],FILTER_SANITIZE_STRING);
            $mdp=filter_var($_POST['mdp'],FILTER_SANITIZE_STRING);
            $login=Account::select("login")->where('login','=',"$id")->count();
            if($login==1 and password_verify($mdp,Account::select("password")->where('login','=',"$id")->get()->toArray()[0]["password"])){
                $app->redirect($app->request->getRootUri());
            } else {
                $vue = new VueConnexion(null);
                $vue->render(INTERFACE_MAUVAISE_COMBINAISON);
            }
        }

    }

    private function creerUser($login,$mdp){
        $compte = new Account();
        $compte->login = $login;
        $hash = password_hash($mdp, PASSWORD_DEFAULT, ['cost' => 12]);
        $compte->password = $hash;
        $compte->save();
    }
}
