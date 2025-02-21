<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'appointment_id',
        'amount',
        'method',
        'status',
        'payment_date',
        'file',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id'); 
    //     // 'user_id' es la columna que conecta Payment con User
    // }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id'); 
        // 'appointment_id' es la columna que conecta Payment con Appointment
    }
}
