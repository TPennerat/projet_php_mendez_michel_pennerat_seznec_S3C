<?php
namespace mywishlist\models;
use Illuminate\Database\Eloquent\Model;

class Message extends Model{
  protected $table = 'message';
  protected $primaryKey = 'idMessage' ;
  public $timestamps = false ;

    public function liste() {
        return $this->belongsTo('\mywishlist\models\Liste','no');
    }

    public function account() {
        return $this->belongsTo('\mywishlist\models\Account','login');
    }
}
