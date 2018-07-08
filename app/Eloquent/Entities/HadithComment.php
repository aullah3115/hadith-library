<?php

namespace App\Eloquent\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class HadithComment extends Model
{

  use TransformableTrait;

  protected $fillable = [
    'hadith_id',
    'commentary_id',
    'blurb',
  ];

  public function commentary(){
    return $this->belongsTo('App\Eloquent\Entities\Commentary');
  }

  public function hadith(){
    return $this->belongsTo('App\Eloquent\Entities\Hadith');
  }
}
