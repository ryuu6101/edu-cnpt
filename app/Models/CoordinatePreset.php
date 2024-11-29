<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoordinatePreset extends Model
{
    use HasFactory, Filterable;

    protected $fillable = [
        'name',
        'department',
        'school',
        'class',
        'semester',
        'subject',
        'starting_row',
        'is_default',
    ];
}
