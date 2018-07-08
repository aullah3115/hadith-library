<?php

namespace App\Eloquent\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Bio extends Model
{
    use TransformableTrait;

    protected $guarded = [];

    public function source(){
      return $this->belongsTo('App\Eloquent\Entities\BioBook', 'bio_book_id');
    }

    public function narrator(){
      return $this->belongsTo('App\Eloquent\Entities\Narrator');
    }
}
