<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarberService extends Model
{
    use HasFactory;

    protected $fillable = [
        'barber_id',
        'name',
        'price',
    ];

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }

    public function userappointments()
    {
        return $this->hasMany(UserAppointment::class, 'service_id');
    }
}
