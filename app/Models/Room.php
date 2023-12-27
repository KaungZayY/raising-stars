<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SDamian\Larasort\AutoSortable;

class Room extends Model
{
    use HasFactory,SoftDeletes,AutoSortable;

    protected $fillable = [
        'room_number',
        'floor_number',
        'seat_capacity',
    ];

    protected array $sortables = [
        'id',
        'room_number',
        'floor_number',
        'seat_capacity',
    ];
}
