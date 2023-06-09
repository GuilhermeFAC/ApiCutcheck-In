<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarberTestimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'barber_id',
        'name',
        'rate',
        'body',
    ];

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }
}
