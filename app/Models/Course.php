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
        'fees',
    ];

    protected $fillable = [
        'course',
        'from_age',
        'to_age',
        'fees',
        'description',
    ];

    public function modules()
    {
        return $this->belongsToMany(Module::class,'module_course');
    }

    public function moduleAssigned(Module $module)
    {
        return $this->modules->contains('module_id',$module->id);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
