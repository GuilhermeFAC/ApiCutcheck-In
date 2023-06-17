<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarberAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'barber_id',
        'weekday',
        'hours',
        'active'
    ];

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }

    public function userappointments()
    {
        return $this->hasMany(UserAppointment::class, 'barber_id', 'barber_id');
    }
}
