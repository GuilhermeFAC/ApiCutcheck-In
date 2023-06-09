<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarberPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'barber_id',
        'url',
    ];

    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }
}
