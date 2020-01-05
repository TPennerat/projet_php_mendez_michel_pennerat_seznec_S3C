<?php


namespace mywishlist\controleur;


use mywishlist\models\Account;
use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\vue\VueReservation;
use const mywishlist\vue\AFFICHER_RESERVATION_ITEM;
use const mywishlist\vue\AFFICHER_RESERVATION_ITEM_INCORRECT;
use const mywishlist\vue\REMERCIEMENT;

class ControleurReservation
{
    public function afficherInterfaceReserv($id){
        $vue = new VueReservation($id);
        $vue->render(AFFICHER_RESERVATION_ITEM);
    }

    public function reserverItem($id){
        if (isset($_POST['nomReserv'])){
            $log = filter_var($_POST['nomReserv'],FILTER_SANITIZE_STRING);
            $res = Account::find($log);
            if ($res != null){
                $no = unserialize($_COOKIE['token_liste_reserv']);
                $l = Liste::find($no);
                $l->items()->updateExistingPivot($id,["reserve"=>1,"loginReserv"=>$log]);
                $vue = new VueReservation($id);
                $vue->render(REMERCIEMENT);
            } else {
                $vue = new VueReservation($id);
                $vue->render(AFFICHER_RESERVATION_ITEM_INCORRECT);
            }
        }

    }
}