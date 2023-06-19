<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFavorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'barber_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function barber()
    {
        return $this->belongsTo(Barber::class, 'barber_id');
    }
}
