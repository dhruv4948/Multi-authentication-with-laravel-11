<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;


    public $table = 'task';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsToMany(User::class, 'user__task', 'user_id', 'task_id');
        // return $this->hasM(User::class, );
    }

    public function teamLeaderName()
    {
        return $this->hasMany(User::class, 'id', 'leader_id');
    }





    public function assignedTask(){
        return $this->hasMany(task_emp::class,);
    }
    

}
