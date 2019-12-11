<?php

namespace mywishlist\controleur;
use mywishlist\models\Item;
use \mywishlist\vue\VueFormulaire;
use Slim\Slim;
use const mywishlist\vue\FORMULAIRE_ITEM;

class ControleurAdminItem {

  public function afficherFormulaire(){
      $iteml = \mywishlist\models\Liste::all();
      $vue = new VueFormulaire($iteml);
      $vue->render(FORMULAIRE_ITEM);
  }

  public function ajouterItemBD(){
      $app= Slim::getInstance();
      if (isset($_POST['nomItem']) && isset($_POST['descr']) && isset($_POST['select'])) {
          $nom = filter_var($app->request()->post('nomItem'),FILTER_SANITIZE_STRING);
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

          $item->liste_id=filter_var($app->request()->post('select'),FILTER_SANITIZE_NUMBER_INT);
          $item->save();
          $i = Item::select('id')->where('nom','=',$nom)->get();
          $app->redirect($app->request->getRootURI().'/afficherItem/token/'.$i['0']['id']);
      }
  }
}
