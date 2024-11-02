<?php

namespace App\Filters;

class VneduFileFilter extends QueryFilter
{
    protected $filterable = [
        'id',
        'department_id',
        'school_id',
        'class_id',
        'semester_id',
    ];
    
    public function filterFileName($name) {
        return $this->builder->where('file_name', 'like', '%' . $name . '%');
    }
}

