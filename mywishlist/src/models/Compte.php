<?php
namespace mywishlist\models;
use Illuminate\Database\Eloquent\Model;

class Compte extends Model{
    protected $table = 'compte';
    protected $primaryKey = 'login' ;
    public $timestamps = false ;

}
