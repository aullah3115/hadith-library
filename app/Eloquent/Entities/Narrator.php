<?php

namespace App\Eloquent\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Narrator extends Model
{

    use TransformableTrait;

    protected $fillable = [
      'neo_id',
      'kunyah',
      'name',
      'used_name',
      'laqab',
      'nisbah',
      'yob',
      'yod',
    ];

    public function hadiths(){
      return $this->belongsToMany('App\Eloquent\Entities\Hadith');
    }

    public function bios(){
      return $this->hasMany('App\Eloquent\Entities\Bio');
    }
}
