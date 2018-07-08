<?php

namespace App\NeoEloquent\Entities;

use Illuminate\Database\Eloquent\Model;
use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;

class Narrator extends NeoEloquent
{
  public function getConnectionName(){
    return 'neo4j';
  }
   protected $connection = 'neo4j';

   protected $label = "Narrator";

   protected $fillable = ['sql_id', 'name', 'used_name', 'kunyah', 'yob', 'yod', 'laqab', 'nisbah'];

   public function links(){
     return $this->hasMany('App\NeoEloquent\Entities\Link', 'NARRATED');
   }
}
