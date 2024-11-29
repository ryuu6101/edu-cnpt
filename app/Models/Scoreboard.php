<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scoreboard extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'semester_id',
        'department_id',
        'school_id',
        'class_id',
        'student_id',
        'subject_id',
        'tx1',
        'tx2',
        'tx3',
        'tx4',
        'tx5',
        'ddggk',
        'ddgck',
        'vnedu_subject_id',
    ];

    public function semester() {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function subject() {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function student() {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function department() {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function school() {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function class() {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }
}
