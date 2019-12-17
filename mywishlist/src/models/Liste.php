<?php
namespace mywishlist\models;
use Illuminate\Database\Eloquent\Model;

class Liste extends Model{
  protected $table = 'liste';
  protected $primaryKey = 'no' ;
  public $timestamps = false ;

    public function items() {
        return $this->belongsToMany('\mywishlist\models\Item') ;
    }
}
