<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task_emp extends Model
{
    public $table  = 'task_emp';
    use HasFactory;


    public function getEmpTask(){
        return $this->hasMany(Task::class,'id','task_id');
    }
}
