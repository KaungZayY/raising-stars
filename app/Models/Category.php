<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SDamian\Larasort\AutoSortable;

class Category extends Model
{
    use HasFactory, SoftDeletes,AutoSortable;

    private array $sortables = [
        'id',
        'category',
        'status',
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_category');
    }
}
