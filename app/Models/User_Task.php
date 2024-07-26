<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Task extends Model
{
    use HasFactory;
    public $table = 'user__task';
    public $primaryKey = 'user_id';

    protected $fillable = [
        'user_id',
        'task_id',
    ];


}
