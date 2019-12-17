<?php

namespace mywishlist\controleur;
use mywishlist\models\Item;
use mywishlist\models\Liste;
use \mywishlist\vue\VueFormulaire;
use Slim\Slim;
use const mywishlist\vue\FORMULAIRE_ITEM;

class ControleurAdminItem {

  public function afficherFormulaire(){
      $iteml = Liste::all();
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
          if(!is_uploaded_file($_FILES['image']['tmp_name'])){ //le ! ne devrait pas etre la DEBUG
            $nomImage=$_FILES['image']['name'];
            if(!file_exists('/web/img/'.$nomImage)){
                $uploaddir = '/web/img/';
                $uploadfile = $uploaddir . basename($_FILES['image']['name']);
                echo $uploadfile;
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile); //Ne marche pas quand on veux ajouter une nouvelle image DEBUG
            }
            $item->img=$nomImage;
          }else{
            $item->img='default.jpg';
          }

          //$item->Liste_id=filter_var($app->request()->post('select'),FILTER_SANITIZE_NUMBER_INT);
          $item->save();
          $i = Item::select('id')->where('nom','=',$nom)->get();
          $app->redirect($app->request->getRootURI().'/afficherItem/token/'.$i['0']['id']);
      }
  }
}
