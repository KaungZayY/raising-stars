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
        'course_id',
        'session',
        'schedule_description',
        'student_limit',
    ];

    protected array $sortables = [
        'id',
        'start_date',
        'end_date',
        'session',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'schedule_student');
    }
}
