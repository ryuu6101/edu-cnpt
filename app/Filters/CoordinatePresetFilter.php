<?php

namespace App\Filters;

class CoordinatePresetFilter extends QueryFilter
{
    protected $filterable = [
        'id',
        'department',
        'school',
        'class',
        'semester',
        'subject',
        'starting_row',
    ];
    
    public function filterName($name) {
        return $this->builder->where('name', 'like', '%' . $name . '%');
    }
}

