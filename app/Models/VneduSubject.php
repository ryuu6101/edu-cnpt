<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VneduSubject extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, Filterable;

    // protected $cascadeDeletes = ['vnedu_sheets'];

    protected $fillable = [
        'name',
        'grade',
        'subject_id',
        'optional_name',
        'use_rating_point'
    ];

    public function subject() {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function vnedu_sheets() {
        return $this->hasMany(VneduSheet::class, 'vnedu_subject_id');
    }
}
