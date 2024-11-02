<?php

namespace App\Repositories\Departments;

use App\Models\Department;
use App\Repositories\BaseRepository;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
    public function getModel() {
        return Department::class;
    }
}