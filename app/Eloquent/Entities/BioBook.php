<?php

namespace App\Eloquent\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class BioBook extends Model
{
  use TransformableTrait;

  protected $fillable = [
    'bio_author_id',
    'name',
  ];

  public function author(){
    return $this->belongsTo('App\Eloquent\Entities\BioAuthor');
  }

  public function bios(){
    return $this->hasMany('App\Eloquent\Entities\Bio');
  }
}
