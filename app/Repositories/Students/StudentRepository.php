<?php

namespace App\Repositories\Students;

use App\Models\Student;
use App\Repositories\BaseRepository;

class StudentRepository extends BaseRepository implements StudentRepositoryInterface
{
    public function getModel() {
        return Student::class;
    }
}