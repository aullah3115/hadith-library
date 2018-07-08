<?php

namespace App\Eloquent\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Section extends Model
{

    use TransformableTrait;

    protected $guarded = [];

    public function book(){
      return $this->belongsTo('App\Eloquent\Entities\Book');
    }

    public function parent(){
        return $this->belongsTo('App\Eloquent\Entities\Section', 'id');
    }

    public function children(){
      return $this->hasMany('App\Eloquent\Entities\Section', 'parent_id');
    }

    public function hadith(){
      return $this->hasMany('App\Eloquent\Entities\Hadith');
    }


}
