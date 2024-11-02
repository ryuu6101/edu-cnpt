<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, Filterable;

    protected $fillable = [
        'fullname',
        'id_code',
        'student_code',
        'department_id',
        'school_id',
        'class_id',
        'is_error',
    ];

    public function class() {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function scoreboards() {
        return $this->hasMany(Scoreboard::class, 'student_id');
    }
}
