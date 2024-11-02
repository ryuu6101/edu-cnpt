<?php

namespace App\Repositories\Schools;

use App\Models\School;
use App\Repositories\BaseRepository;

class SchoolRepository extends BaseRepository implements SchoolRepositoryInterface
{
    public function getModel() {
        return School::class;
    }
}