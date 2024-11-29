<?php

namespace App\Filters;

class VneduSubjectFilter extends QueryFilter
{
    protected $filterable = [
        'id',
        'grade',
        'use_rating_point',
        'optinal_name',
    ];
    
    public function filterName($name) {
        return $this->builder->where('name', 'like', '%' . $name . '%');
    }
}

