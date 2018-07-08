<?php

namespace App\NeoEloquent\Entities;

use Illuminate\Database\Eloquent\Model;
use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;

class User extends NeoEloquent
{

  public function getConnectionName(){
    return 'neo4j';
  }
   protected $connection = 'neo4j';

   protected $label = "User";

   protected $fillable = ['sql_id', 'name', 'email', 'password',];
}
