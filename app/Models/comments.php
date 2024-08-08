<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->hasMany(User::class, 'id', 'user_id')->whereIn('role', ['Employees', 'Team_leaders', 'Admin']);
    }
    public function emptoteam()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
    public function tasks()
    {
        return $this->hasMany(Task::class, 'id', 'task_id');
    }
}