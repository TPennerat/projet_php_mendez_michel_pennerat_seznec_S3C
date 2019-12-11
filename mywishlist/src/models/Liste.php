<?php
namespace mywishlist\models;
class Liste extends \Illuminate\Database\Eloquent\Model{
  protected $table = 'liste';
  protected $primaryKey = 'no' ;
  public $timestamps = false ;
    /**
     * @var array|null
     */
    private $titre;
    /**
     * @var array|null
     */
    private $description;

    public function items() {
        return $this->hasMany('\mywishlist\models\Item','liste_id') ;
    }
}
