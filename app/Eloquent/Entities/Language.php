<?php

namespace App\Eloquent\Entities;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
      'name',
      'direction'
    ];

    public function hadith_translations(){
      return $this->hasMAny('App\Eloquent\Entities\HadithTranslation');
    }
}
