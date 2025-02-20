<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accountant extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'profile_photo',
        'specialization',
        'experience_years',
        'available',
    ];
}