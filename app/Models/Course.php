<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SDamian\Larasort\AutoSortable;

class Course extends Model
{
    use HasFactory,SoftDeletes,AutoSortable;

    private array $sortables = [
        'id',
        'course',
        'from_age',
    ];
}
