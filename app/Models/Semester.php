<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Semester extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, Filterable;

    protected $cascadeDeletes = ['records', 'vnedu_sheets'];

    protected $fillable = [
        'school_year',
        'semester',
    ];

    public function records() {
        return $this->hasMany(Scoreboard::class, 'semester_id');
    }

    public function vnedu_files() {
        return $this->hasMany(VneduFile::class, 'semester_id');
    }
}
