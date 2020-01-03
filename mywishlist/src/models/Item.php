<?php
namespace mywishlist\models;
use Illuminate\Database\Eloquent\Model;

class Item extends Model{
  protected $table = 'Item';
  protected $primaryKey = 'id' ;
  public $timestamps = false ;

  public function liste() {
    return $this->belongsToMany('\mywishlist\models\Liste','item_liste','item_id');
  }
}
