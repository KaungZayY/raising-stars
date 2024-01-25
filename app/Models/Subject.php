<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SDamian\Larasort\AutoSortable;

class Subject extends Model
{
    use HasFactory,SoftDeletes, AutoSortable;
    
    private array $sortables = [
        'id',
        'subject',
    ];

    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}
