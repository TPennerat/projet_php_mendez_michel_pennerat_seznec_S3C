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
        if (isset($_POST['nomReserv']) and isset($_POST['messReserv'])) {
            $log = filter_var($_POST['nomReserv'], FILTER_SANITIZE_STRING);
            $message = filter_var($_POST['messReserv'], FILTER_SANITIZE_STRING);
            $no = unserialize($_COOKIE['token_liste_reserv']);
            $l = Liste::find($no);
            if ($log == " ") {
                $vue = new VueReservation(["id" => $id, "mess" => "Le nom ne peut pas contenir de caractère spéciaux"]);
                $vue->render(AFFICHER_RESERVATION_ITEM_INCORRECT);
            } elseif ($l['createur'] == $log) {
                $vue = new VueReservation(["id"=>$id,"mess"=>"Le nom ne peut pas être celui du créateur"]);
                $vue->render(AFFICHER_RESERVATION_ITEM_INCORRECT);
            }else {
                $res = 0;
                foreach ($l->items as $i) {
                    if ($i['item_id'] == $id) {
                        $res = $log->pivot->reserve;
                    }
                }
                if ($res== 1) {
                    $vue = new VueReservation(["id"=>$id,"mess"=>"Item déjà réservé"]);
                    $vue->render(AFFICHER_RESERVATION_ITEM_INCORRECT);
                } else {
                    $l->items()->updateExistingPivot($id,["reserve"=>1,"loginReserv"=>$log,"messageReserve"=>$message]);
                    $vue = new VueReservation(['id'=>$l['no'],'token'=>$l['tokenPartage']]);
                    $vue->render(REMERCIEMENT);
                }

            }
        }

    }
}