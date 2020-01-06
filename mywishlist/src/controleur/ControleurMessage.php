<?php


namespace mywishlist\controleur;


use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\models\Message;
use mywishlist\vue\VueParticipant;
use Slim\Slim;
use const mywishlist\vue\AFFICHER_LISTE_NO_CO;

class ControleurMessage
{
    public function posterMessage($token,$id){
        if (isset($_POST['message']) and isset($_COOKIE['token_liste_reserv'])){
            if (isset($_SESSION['id_connect'])) {
                $m = new Message();
                $mess = filter_var($_POST['message'],FILTER_SANITIZE_STRING);
                $m->no = $id;
                $m->login = $_SESSION['id_connect'];
                $m->message = $mess;
                $m->save();
                Slim::getInstance()->redirect(Slim::getInstance()->request->getPath());
            } else {
                $vue = new VueParticipant(Liste::find(unserialize($_COOKIE['token_liste_reserv'])));
                $vue->render(AFFICHER_LISTE_NO_CO);
            }

        }

    }
}