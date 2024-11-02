<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes, Filterable;
    
    protected $fillable = [
        'name',
        'export_name',
    ];

    public function schools() {
        return $this->hasMany(School::class, 'department_id');
    }
}
