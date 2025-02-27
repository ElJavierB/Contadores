<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Accountant;

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

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function accountant(){
        return $this->belongsTo(Accountant::class);
    }

}