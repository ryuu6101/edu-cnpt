<?php

namespace App\Filters;

class ClassRoomFilter extends QueryFilter
{
    protected $filterable = [
        'id',
        'grade',
        'department_id',
        'school_id',
    ];
    
    public function filterName($name) {
        return $this->builder->where('name', 'like', '%' . $name . '%');
    }
}

