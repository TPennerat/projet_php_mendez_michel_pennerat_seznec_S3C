<?php


namespace mywishlist\controleur;


use mywishlist\models\Message;
use Slim\Slim;

class ControleurMessage
{
    public function posterMessage($token,$id){
        if (isset($_POST['message'])){
            $m = new Message();
            $mess = filter_var($_POST['message'],FILTER_SANITIZE_STRING);
            $m->no = $id;
            $m->login = $_SESSION['id_connect'];
            $m->message = $mess;
            $m->save();
            Slim::getInstance()->redirect(Slim::getInstance()->request->getPath());
        }

    }
}