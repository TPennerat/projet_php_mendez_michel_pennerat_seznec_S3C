<?php
namespace mywishlist\controleur;
use \mywishlist\vue\VueFormulaire;

class ControleurAdminListe {
  //methode potentielle
  public function getListe($no){

  }

  public function afficherFormulaire(){
      $vue = new VueFormulaire(null);
      $vue->render(1);

      // $app=\Slim\Slim::getInstance();
      // $nom = $app->request()->post('nomListe');
      // $items = $app->request()->post('items');
  }

}
