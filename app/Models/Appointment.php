<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'accountant_id',
        'date',
        'time',
        'status',
        'notes',
    ];
}
