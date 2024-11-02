<?php

namespace App\Repositories\Semesters;

use App\Models\Semester;
use App\Repositories\BaseRepository;

class SemesterRepository extends BaseRepository implements SemesterRepositoryInterface
{
    public function getModel() {
        return Semester::class;
    }
}