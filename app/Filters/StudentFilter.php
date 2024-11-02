<?php

namespace App\Filters;

class StudentFilter extends QueryFilter
{
    protected $filterable = [
        'id',
        'id_code',
        'student_code',
        'department_id',
        'school_id',
        'class_id',
    ];
    
    public function filterFullName($name) {
        return $this->builder->where('fullname', 'like', '%' . $name . '%');
    }

    // public function filterStudentCode($student_code) {
    //     return $this->builder->where('student_code', 'like', '%' . $student_code . '%');
    // }
}

