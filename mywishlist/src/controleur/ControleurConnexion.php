<?php

namespace mywishlist\controleur;

use mywishlist\models\Account;
use mywishlist\vue\VueConnexion;
use Slim\Slim;
use const mywishlist\vue\INTERFACE_CHANGEMENT_MDP;
use const mywishlist\vue\INTERFACE_CHANGEMENT_MDP_INCORRECT;
use const mywishlist\vue\INTERFACE_CHANGEMENT_MDP_INCORRECT_LOGIN;
use const mywishlist\vue\INTERFACE_CHANGEMENT_MDP_INCORRECT_MDP;
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
                    $_SESSION['token']=bin2hex(random_bytes(32));
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
                $_SESSION['id_connect']=Account::select("login")->where('login','=',"$id")->first()->login;
                $app->redirect($app->request->getRootUri());
            } else {
                $vue = new VueConnexion(null);
                $vue->render(INTERFACE_MAUVAISE_COMBINAISON);
            }
        }
    }

    public function seDeconnecter(){
      $app= Slim::getInstance();
      $_SESSION['id_connect']=null;
      session_destroy();
      $app->redirect($app->urlFor('racine'));
    }

    private function creerUser($login,$mdp){
        $compte = new Account();
        $compte->login = $login;
        $hash = password_hash($mdp, PASSWORD_DEFAULT, ['cost' => 12]);
        $compte->password = $hash;
        $compte->save();
    }

    private function modifUser($login,$mdp){
        $compte = Account::find($login);
        $hash = password_hash($mdp, PASSWORD_DEFAULT, ['cost' => 12]);
        $compte->password = $hash;
        $compte->update();
    }

    public function afficherModifierMotDePasse(){
        $vue = new VueConnexion(null);
        $vue->render(INTERFACE_CHANGEMENT_MDP);
    }

    public function modifierMotDePasseUser(){
        if (isset($_POST['identifiant']) and isset($_POST['mdp']) and isset($_POST['mdpconf'])){
            $id = filter_var($_POST['identifiant'],FILTER_SANITIZE_STRING);
            $pass = filter_var($_POST['mdp'],FILTER_SANITIZE_STRING);
            $confpass = filter_var($_POST['mdpconf'],FILTER_SANITIZE_STRING);
            if ($pass==$confpass){
                $user = Account::find($id);
                if ($user != null){
                    $this->modifUser($id,$pass);
                    Slim::getInstance()->redirect(Slim::getInstance()->urlFor('connexion'));
                }
                $vue = new VueConnexion(null);
                $vue->render(INTERFACE_CHANGEMENT_MDP_INCORRECT_LOGIN);
            }
            $vue = new VueConnexion(null);
            $vue->render(INTERFACE_CHANGEMENT_MDP_INCORRECT_MDP);
        }
    }
}
