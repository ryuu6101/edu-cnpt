<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassRoom extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, Filterable;

    // protected $cascadeDeletes = ['students'];

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'grade',
        'department_id',
        'school_id',
    ];

    public function department() {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function school() {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function students() {
        return $this->hasMany(Student::class, 'class_id')->where('is_error', false);
    }

    public function subjects() {
        return $this->belongsToMany(Subject::class, 'classes_subjects', 'class_id', 'subject_id')->withPivot('id');
    }

    public function scoreboards() {
        return $this->hasMany(Scoreboards::class, 'class_id');
    }

    public function error_students() {
        return $this->hasMany(Student::class, 'class_id')->where('is_error', true);
    }

    public function all_students() {
        return $this->hasMany(Student::class, 'class_id');
    }
}
