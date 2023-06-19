<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Barber extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'endereco',
        'cidade',
        'estado',
        'telefone',
        'type_user',
        'avatar',
        'stars',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function barberavailability()
    {
        return $this->hasMany(BarberAvailability::class);
    }

    public function barberphotos()
    {
        return $this->hasMany(BarberPhoto::class);
    }

    public function barbertestimonial()
    {
        return $this->hasMany(BarberTestimonial::class);
    }

    public function barberservice()
    {
        return $this->hasMany(BarberService::class);
    }

    public function userappointments()
    {
        return $this->hasMany(UserAppointment::class);
    }

    public function favorites()
    {
        return $this->hasMany(UserFavorite::class, 'barber_id');
    }
}
