<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VneduFile extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, Filterable;

    protected $fillable = [
        'file_name',
        'semester_id',
        'school_id',
        'class_id',
    ];

    public function semester() {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    public function school() {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function class() {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function vnedu_sheets() {
        return $this->hasMany(VneduSheet::class, 'vnedu_file_id');
    }
}
