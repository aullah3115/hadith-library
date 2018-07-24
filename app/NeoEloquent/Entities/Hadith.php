<?php

namespace App\NeoEloquent\Entities;

use Illuminate\Database\Eloquent\Model;
use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;

class Hadith extends NeoEloquent
{

  public function getConnectionName(){
    return 'neo4j';
  }
   protected $connection = 'neo4j';

   protected $label = "Hadith";

   protected $fillable = ['sql_id', 'number', 'chain', 'blurb', 'book', 'section'];

   public function book(){
     return $this->belongsTo('App\NeoEloquent\Entities\Book', 'CONTAINS');
   }

   public function section(){
     return $this->belongsTo('App\NeoEloquent\Entities\Section', 'CONTAINS');
   }

   public function links(){
     return $this->hasMany('App\NeoEloquent\Entities\Link', 'LINK');
   }

   public function related_hadith(){
     return $this->belongsToMany('App\NeoEloquent\Entities\Hadith', 'RELATED_TO');
   }

}
