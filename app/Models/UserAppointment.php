<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAppointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'barber_id',
        'service_id',
        'ap_datetime',
    ];

    public function barberavailability()
    {
        return $this->belongsTo(BarberAvailability::class, 'barber_id', 'barber_id');
    }
}
