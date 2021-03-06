<?php
namespace mywishlist\models;
use Illuminate\Database\Eloquent\Model;

class Account extends Model{
    protected $table = 'account';
    protected $primaryKey = 'login' ;
    public $timestamps = false ;

    public function messages() {
        return $this->hasMany('\mywishlist\models\Message','login');
    }
}
