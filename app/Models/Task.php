<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
//    use HasFactory;
    //use SoftDeletes;
    protected $fillable = array('task_date', 'number', 'task_name', 'item', 'task', 'note', 'deadline', 'task_status_id');
    protected $table = 'tasks';


    //скорее всего не нужно - связь ниже????

//    public function status()
//    {
//        return $this->belongsTo(Status::class, 'task_status_id')->withDefault([
//            'status' => '!!!не определен либо удален',
//        ]);
//    }

    public function users()
		{
			return $this->belongsToMany(User::class, 'task_users', 'task_id', 'user_id')->withPivot('status_id')->withTimestamps();
		}

}
