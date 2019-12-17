<?php
namespace mywishlist\models;
use Illuminate\Database\Eloquent\Model;

class List extends Model{
  protected $table = 'List';
  protected $primaryKey = 'no' ;
  public $timestamps = false ;

    public function items() {
        return $this->hasMany('\mywishlist\models\Item','liste_id') ;
    }
}
