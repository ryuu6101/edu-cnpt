<?php

namespace App\Repositories\Subjects;

use App\Models\Subject;
use App\Repositories\BaseRepository;

class SubjectRepository extends BaseRepository implements SubjectRepositoryInterface
{
    public function getModel() {
        return Subject::class;
    }
}