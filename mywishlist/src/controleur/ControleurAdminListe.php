<?php
namespace mywishlist\controleur;
use mywishlist\models\Item;
use mywishlist\models\Liste;
use \mywishlist\vue\VueFormulaire;
use Slim\Slim;
use const mywishlist\vue\FORMUALIRE_LISTE_INCORRECT;
use const mywishlist\vue\FORMULAIRE_LISTE;

class ControleurAdminListe {

    public function afficherFormulaire(){
        $iteml = Item::all();
        $vue = new VueFormulaire($iteml->toArray());
        $vue->render(FORMULAIRE_LISTE);
    }

    public function ajouterListeBD(){
        $app= Slim::getInstance();
        if (isset($_POST['nomListe']) && isset($_POST['descr'])) {
            $nom = filter_var($app->request()->post('nomListe'),FILTER_SANITIZE_STRING);
            if (Liste::select('*')->where('titre','=',$nom)->count()==0) {
                $liste = new Liste();
                $liste->titre = $nom;
                $liste->description = filter_var($app->request()->post('descr'), FILTER_SANITIZE_STRING);
                $liste->token=bin2hex(random_bytes(8));
                $liste->save();
                $l = Liste::select('no')->where('titre', '=', $nom)->get();
                $i=array();
                foreach (Item::all() as $item) {
                    if (isset($_POST["$item->id"])){
                        $liste->items()->attach($item->id);
                    }

                }
                $liste->save();
                $app->redirect($app->urlFor('getListe', ['token'=>$liste->token, 'id'=>$liste->no]));
            }
            else {
                $iteml = Item::all();
                $vue = new VueFormulaire($iteml->toArray());
                $vue->render(FORMUALIRE_LISTE_INCORRECT);
            }
        }
    }
}
