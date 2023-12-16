<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_category');//many to many with category class, dummy table is post_category
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function liked(User $user)
    {
        return $this->likes->contains('user_id',$user->id);
    }
}
