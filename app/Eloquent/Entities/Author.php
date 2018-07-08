<?php

namespace App\Eloquent\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Author.
 *
 * @package namespace App\Eloquent\Entities;
 */
class Author extends Model implements Transformable
{

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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

    public function books(){
      return $this->hasMany('App\Eloquent\Entities\Book');
    }
}
