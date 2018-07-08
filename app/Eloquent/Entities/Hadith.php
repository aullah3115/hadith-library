<?php

namespace App\Eloquent\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Hadith extends Model
{
    use TransformableTrait;

    protected $guarded = [];

    public function section(){
      return $this->belongsTo('App\Eloquent\Entities\Section');
    }

    public function narrators(){
      return $this->belongsToMany('App\Eloquent\Entities\Narrator')->as('chain')->withPivot('position')->withTimestamps()->orderBy('hadith_narrator.position');
    }

    public function comments(){
      return $this->hasMAny('App\Eloquent\Entities\HadithComment');
    }

    public function translations(){
      return $this->hasMAny('App\Eloquent\Entities\HadithTranslation');
    }
}
