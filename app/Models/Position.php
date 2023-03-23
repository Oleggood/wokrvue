<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = array('position', 'is_director', 'is_deputy_director');
    protected $table = 'positions';

}
