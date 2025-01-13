<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User2 extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'phone',
    ];
}
