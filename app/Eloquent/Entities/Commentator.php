<?php

namespace App\Eloquent\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Commentator extends Model
{

  use TransformableTrait;

  protected $guarded = [];

  public function books(){

    return $this->hasMany('App\Eloquent\Entities\Commentary');
  }
}
