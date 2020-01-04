<?php


namespace mywishlist\controleur;


use mywishlist\vue\VueReservation;
use const mywishlist\vue\AFFICHER_RESERVATION_ITEM;
use const mywishlist\vue\REMERCIEMENT;

class ControleurReservation
{
    public function afficherInterfaceReserv($id){
        if (isset($_COOKIE['token_liste_reserv'])){
            setcookie("token_liste_reserv",$_COOKIE['token_liste_reserv']);
        }
        $vue = new VueReservation($id);
        $vue->render(AFFICHER_RESERVATION_ITEM);
    }

    public function reserverItem($id){
        $vue = new VueReservation($id);
        $vue->render(REMERCIEMENT);
    }
}