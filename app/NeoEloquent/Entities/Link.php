<?php

namespace App\NeoEloquent\Entities;

use Illuminate\Database\Eloquent\Model;
use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;

class Link extends NeoEloquent
{
  public function getConnectionName(){
    return 'neo4j';
  }
   protected $connection = 'neo4j';

   protected $label = "Link";

   protected $fillable = ['position', 'hadith_id'];

   public function hadith(){
     return $this->belongsTo('App\NeoEloquent\Entities\Hadith', 'LINK');
   }

   public function narrator(){
     return $this->belongsTo('App\NeoEloquent\Entities\Narrator', 'NARRATED');
   }

   public function link(){
     return $this->hasOne('App\NeoEloquent\Entities\Link', 'FROM');
   }

}
