<?php

namespace App\Eloquent\Entities;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['email', 'message'];
}
