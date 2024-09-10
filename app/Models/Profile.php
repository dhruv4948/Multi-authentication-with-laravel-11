<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    public $table = 'profile';
    public $timestamps = false;
    protected $fillable = [
        'number',
        'DOB',
        'Gender',
        'Education',
        'Address',
        'City',
        'Country',
    ];
    public function users()
    {
        return $this->hasOne(User::class, );
    }
}
