<?php
namespace mywishlist\models;
use Illuminate\Database\Eloquent\Model;

class Account extends Model{
    protected $table = 'account';
    protected $primaryKey = 'login' ;
    public $timestamps = false ;

}
