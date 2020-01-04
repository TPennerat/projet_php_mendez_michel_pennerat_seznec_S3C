<?php
namespace mywishlist\controleur;
use mywishlist\models\Item;
use mywishlist\models\Liste;
use \mywishlist\vue\VueFormulaire;
use Slim\Slim;
use const mywishlist\vue\FORMULAIRE_LISTE_INCORRECT;
use const mywishlist\vue\FORMULAIRE_LISTE_PAS_CO;
use const mywishlist\vue\FORMULAIRE_LISTE;
use const mywishlist\vue\FORMULAIRE_SUPPRESSION_LISTE;

class ControleurAdminListe {

    public function afficherFormulaire(){
        if (isset($_SESSION['id_connect'])) {
            $iteml = Item::all();
            $vue = new VueFormulaire($iteml->toArray());
            $vue->render(FORMULAIRE_LISTE);
        } else {
            $iteml = null;
            $vue = new VueFormulaire($iteml);
            $vue->render(FORMULAIRE_LISTE_PAS_CO);
        }
    }

    public function ajouterListeBD(){
        $app= Slim::getInstance();
        if (isset($_POST['nomListe']) && isset($_POST['descr'])) {
            $nom = filter_var($app->request()->post('nomListe'),FILTER_SANITIZE_STRING);
            if (Liste::select('*')->where('titre','=',$nom)->count()==0) {
                $liste = new Liste();
                $liste->titre = $nom;
                $liste->createur = $_SESSION['id_connect'];
                $liste->description = filter_var($app->request()->post('descr'), FILTER_SANITIZE_STRING);
                try {
                    $token = bin2hex(random_bytes(8));
                    while (Liste::all()->where('token','=',$token)->count()==1) {
                        $token = bin2hex(random_bytes(8));
                    }
                    $liste->token = $token;
                } catch (\Exception $e) {
                    //try catch ?
                }
                if(isset($_POST['Publique'])){
                  $liste->publique = 1;
                }
                $liste->save();
                $l = Liste::select('no')->where('titre', '=', $nom)->get();
                $i = array();
                foreach (Item::all() as $item) {
                    if (isset($_POST["$item->id"])){
                        $liste->items()->attach($item->id,["loginReserv"=>null]);
                    }

                }
                $liste->save();
                $app->redirect($app->urlFor('getListe', ['token'=>$liste->token, 'id'=>$liste->no]));
            }
            else {
                $iteml = Item::all();
                $vue = new VueFormulaire($iteml->toArray());
                $vue->render(FORMULAIRE_LISTE_INCORRECT);
            }
        }
    }

    public function afficherSuppressionListe($token,$id){
        $vue = new VueFormulaire(["0"=>$token,"1"=>$id]);
        $vue->render(FORMULAIRE_SUPPRESSION_LISTE);
    }

    public function supprimerListe($id){
        $liste_a_supp = Liste::find($id);
        $liste_a_supp->items()->detach();
        $liste_a_supp->delete();
        $app = Slim::getInstance();
        $app->redirect($app->request->getRootUri());
    }
}
