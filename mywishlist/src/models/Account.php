<?php
namespace mywishlist\models;
use Illuminate\Database\Eloquent\Model;

class Account extends Model{
    protected $table = 'Account';
    protected $primaryKey = 'login' ;
    public $timestamps = false ;

}
