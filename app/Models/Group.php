<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SDamian\Larasort\AutoSortable;

class Group extends Model
{
    use HasFactory,SoftDeletes,AutoSortable;

    protected $fillable = [
        'name',
        'description',
    ];

    protected array $sortables = [
        'id',
        'name',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class,'user_group')->withPivot('created_at');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
