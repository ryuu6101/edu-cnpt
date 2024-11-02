<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, Filterable;

    protected $cascadeDeletes = ['records'];

    protected $fillable = [
        'name',
        'grade',
        'use_digit_point',
    ];

    public function classes() {
        return $this->belongsToMany(ClassRoom::class, 'classes_subjects', 'subject_id', 'class_id');
    }

    public function scoreboards() {
        return $this->hasMany(Scoreboard::class, 'subject_id');
    }

    public function vnedu_subject() {
        return $this->hasOne(VneduSubject::class, 'subject_id');
    }
}
