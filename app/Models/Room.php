<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'room_number',
        'price',
        'description',
        'room_type'
    ];

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class);
    }
}
