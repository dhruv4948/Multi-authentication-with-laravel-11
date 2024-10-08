<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function client()
    {
        return $this->hasMany(Client::class, 'id', 'client_id');
    }

}
