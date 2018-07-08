<?php

namespace App\Eloquent\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class HadithTranslation extends Model
{
  use TransformableTrait;

  protected $fillable = [
    'hadith_id',
    'language_id',
  ];

  public function language(){
    return $this->belongsTo('App\Eloquent\Entities\Language');
  }

  public function hadith(){
    return $this->belongsTo('App\Eloquent\Entities\Hadith');
  }
}
