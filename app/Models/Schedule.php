<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use SDamian\Larasort\AutoSortable;

class Schedule extends Model
{
    use HasFactory,SoftDeletes,AutoSortable;

    protected $fillable = [
        'start_date',
        'end_date',
    ];

    protected array $sortables = [
        'id',
        'start_date',
        'end_date',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
