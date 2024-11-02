<?php

namespace App\Filters;

class UserFilter extends QueryFilter
{
    protected $filterable = [
        'id',
        'role_id',
        'is_actived',
    ];
    
    public function filterUsername($name) {
        return $this->builder->where('username', 'like', '%' . $name . '%');
    }
}

