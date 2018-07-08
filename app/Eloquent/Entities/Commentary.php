<?php

namespace App\Eloquent\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Commentary extends Model
{
  use TransformableTrait;

  protected $fillable = [
    'commentator_id',
    'book_id',
    'name',
  ];

  public function commentator(){
    return $this->belongsTo('App\Eloquent\Entities\Commentator');
  }

  public function comments(){
    return $this->hasMany('App\Eloquent\Entities\HadithComments');
  }

  public function book(){
    return $this->belongsTo('App\Eloquent\Entities\Book');
  }
}
