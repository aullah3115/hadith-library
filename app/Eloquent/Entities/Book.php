<?php

namespace App\Eloquent\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Book extends Model
{

    use TransformableTrait;

    protected $fillable = ['neo_id', 'name', 'author_id'];

    public function author(){
      return $this->belongsTo('App\Eloquent\Entities\Author');
    }

    public function sections(){
      return $this->hasMany('App\Eloquent\Entities\Section');
    }

    public function commentaries(){
      return $this->hasMany('App\Eloquent\Entities\Commentaries');
    }
}
