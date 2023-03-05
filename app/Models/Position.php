<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{
//    use HasFactory;
//    use SoftDeletes;
    protected $fillable = array('position', 'is_director', 'is_deputy_director');
    protected $table = 'positions';

}
