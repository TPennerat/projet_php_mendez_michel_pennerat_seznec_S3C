<?php
namespace mywishlist\controleur;
use mywishlist\models\Item;
use mywishlist\models\Liste;
use mywishlist\models\Message;
use \mywishlist\vue\VueFormulaire;
use mywishlist\vue\VueParticipant;
use Slim\Slim;
use const mywishlist\vue\AFFICHER_LISTE;
use const mywishlist\vue\BAD_TOKEN;
use const mywishlist\vue\FORMULAIRE_LISTE_INCORRECT;
use const mywishlist\vue\FORMULAIRE_LISTE_PAS_CO;
use const mywishlist\vue\FORMULAIRE_LISTE;
use const mywishlist\vue\FORMULAIRE_SUPPRESSION_LISTE;
use const mywishlist\vue\MODIF_LISTE;

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
                $liste->expiration = filter_var($app->request()->post('expListe'),FILTER_SANITIZE_STRING);
                try {
                    $token = bin2hex(random_bytes(8));
                    while (Liste::all()->where('token','=',$token)->count()==1) {
                        $token = bin2hex(random_bytes(8));
                    }
                    $liste->token = $token;
                    $tokenPartage = bin2hex(random_bytes(8));
                    while (Liste::all()->where('token','=',$tokenPartage)->count()==1) {
                        $tokenPartage = bin2hex(random_bytes(8));
                    }
                    $liste->tokenPartage = $tokenPartage;
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
                        $liste->items()->attach($item->id,["loginReserv"=>null,"etatCagnotte"=>0,"valCagnotte"=>0.0]);
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

    public function afficherModificationListe($token,$no){
        if (Liste::find($no)['token']==$token) {
            $vue = new VueFormulaire(["token"=>$token,"no"=>$no]);
            $vue->render(MODIF_LISTE);
        } else {
            $vue = new VueFormulaire(null);
            $vue->render(BAD_TOKEN);
        }

    }

    public function modifierListeBD($token,$no){
        $l=Liste::find($no);
        if ($l['token']==$token) {
            if (isset($_POST['nomListe'])){
                $l->titre=filter_var($_POST['nomListe'],FILTER_SANITIZE_STRING);
            }
            if (isset($_POST['descr'])){
                $l->description=filter_var($_POST['descr'],FILTER_SANITIZE_STRING);
            }
            if (isset($_POST['expListe'])){
                $l->expiration=filter_var($_POST['expListe'],FILTER_SANITIZE_STRING);
            }
            if (isset($_POST['prive'])){
                $l->publique=0;
            } elseif (isset($_POST['Publique'])) {
                $l->publique=1;
            }
            foreach($l->items as $i){
                $id=$i['id'];
                if (isset($_POST["$id"])){
                    $l->items()->detach($id);
                }
            }
            $l->update();
            foreach (Item::all() as $item) {
                $ok=0;
                $id=$item['id'];
                foreach ($l->items as $mesItems){
                    if ($mesItems['id']==$item['id']){
                        $ok=1;
                    }
                }
                if ($ok==0) {
                    if (isset($_POST["$id"]))
                        $l->items()->attach($id,["loginReserv"=>null,"etatCagnotte"=>0,"valCagnotte"=>0.0]);
                }
            }
            $l->update();
            Slim::getInstance()->redirect(Slim::getInstance()->urlFor('getListe', ['token'=>$l->token, 'id'=>$l->no]));
        } else {
            $vue = new VueFormulaire(null);
            $vue->render(BAD_TOKEN);
        }
    }

    public function supprimerListe($id){
        $message_a_supp = Message::whereRaw("`no`=$id")->get();
        foreach ($message_a_supp as $mess) {
            $mess->delete();
        }
        $liste_a_supp = Liste::find($id);
        $liste_a_supp->items()->detach();
        $liste_a_supp->delete();
        $app = Slim::getInstance();
        $app->redirect($app->request->getRootUri());
    }
}
