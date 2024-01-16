<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'father_name',
        'mother_name',
        'parent_phone',
        'parent_email',
        'parent_occupation',
        'race',
        'nationality',
        'date_of_birth',
        'gender',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
