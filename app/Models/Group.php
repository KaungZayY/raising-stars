<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
    ];

    protected array $sortables = [
        'id',
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class,'user_group');
    }
}
