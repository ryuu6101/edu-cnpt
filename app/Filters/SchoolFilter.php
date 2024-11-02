<?php

namespace App\Filters;

class SchoolFilter extends QueryFilter
{
    protected $filterable = [
        'id',
        'level',
        'department_id',
    ];
    
    public function filterName($name) {
        return $this->builder->where('name', 'like', '%' . $name . '%');
    }
}

