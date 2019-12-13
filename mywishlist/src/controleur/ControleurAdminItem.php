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
          $item=new Item();
          $nom=filter_var($app->request()->post('nomItem'),FILTER_SANITIZE_STRING);
          $item->nom=$nom;
          $item->descr=filter_var($app->request()->post('descr'),FILTER_SANITIZE_STRING);
          if(0==0){//tester si le champ est renseigné et OK
            $nomImage=(array_reverse(explode('\\',$_POST['image'])))[0];
            if(!file_exists('/web/img/'.$nomImage)){
              //A DEBUG ER surement avec $_FILES
              move_uploaded_file($_POST['image'], $app->request->getRootURI().'/web/img/'.$nomImage); //A tester
            }
            $item->img=$nomImage;
          }else{
            $item->img='default.jpg';
          }

          $item->liste_id=filter_var($app->request()->post('select'),FILTER_SANITIZE_NUMBER_INT);
          $item->save();
          $i = Item::select('id')->where('nom','=',$nom)->get();
          $app->redirect($app->request->getRootURI().'/afficherItem/token/'.$i['0']['id']);
      }
  }
}
