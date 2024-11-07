<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class School extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, Filterable;

    protected $cascadeDeletes = ['classes'];

    protected $fillable = [
        'name',
        'export_name',
        'level',
        'department_id',
    ];

    public function department() {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function classes() {
        return $this->hasMany(ClassRoom::class, 'school_id');
    }
}
