<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Excel extends Model
{
    use HasFactory;
    public $table = 'excel_data';
    public $timestamps = false;

    protected $fillable = [
        'uploaded_time',
        'stored_path',
        'table_type',
        'status',
    ];

}
