<?php

namespace mywishlist\controleur;


use mywishlist\vue\VueConnexion;
use const mywishlist\vue\INTERFACE_CONNEXION;

class ControleurConnexion{

    public function afficherInterfaceConnexion(){
        $vue= new VueConnexion(null);
        $vue->render(INTERFACE_CONNEXION);
    }
}
