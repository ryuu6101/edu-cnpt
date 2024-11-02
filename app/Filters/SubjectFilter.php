<?php

namespace App\Filters;

class SubjectFilter extends QueryFilter
{
    protected $filterable = [
        'id',
        'grade',
        'use_digit_point',
    ];
    
    public function filterName($name) {
        return $this->builder->where('name', 'like', '%' . $name . '%');
    }
}

