<?php

namespace mywishlist\controleur;
use mywishlist\models\Item;
use \mywishlist\vue\VueFormulaire;
use Slim\Slim;

class ControleurAdminItem {

  public function afficherFormulaire(){
      $vue = new VueFormulaire(null);
      $vue->render(2);
  }

  public function ajouterItemBD(){
      $app= Slim::getInstance();
      if (isset($_POST['nomItem']) && isset($_POST['descr'])) {
          $nom = $app->request()->post('nomItem');
          $item=new Item();
          $item->nom=filter_var($nom,FILTER_SANITIZE_STRING);
          $item->descr=filter_var($app->request()->post('descr'),FILTER_SANITIZE_STRING);

          $nomImage=(array_reverse(explode('/',$_POST['image'])))[0];
          if (0==0) { //DEBUG
            move_uploaded_file($_POST['image'], $app->request->getRootURI().'/web/img/'.$nomImage); //A tester
            $item->img=$nomImage; //Marche sauf pour le premier affichage
          }else{
            $item->img="default.jpg"; //ne marche pas
          }

          $item->liste_id = 1; //DEBUG
          $item->save();
          $i = Item::select('id')->where('nom','=',$nom)->get();
          $app->redirect($app->request->getRootURI().'/afficherItem/token/'.$i['0']['id']);
      }
  }
}
