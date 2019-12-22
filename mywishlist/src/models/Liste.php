<?php
namespace mywishlist\models;
use Illuminate\Database\Eloquent\Model;

class Liste extends Model{
  protected $table = 'List';
  protected $primaryKey = 'no' ;
  public $timestamps = false ;

    public function items() {
        return $this->belongsToMany('\mywishlist\models\Item','item_liste','liste_no')
            ->withPivot('reserve', 'loginReserv');
    }

    public function messages() {
        return $this->hasMany('\mywishlist\models\Message','no');
    }
}
