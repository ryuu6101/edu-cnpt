<?php

namespace App\Repositories\VneduSubjects;

use App\Repositories\RepositoryInterface;

interface VneduSubjectRepositoryInterface extends RepositoryInterface
{
    public function getUnsyncedSubjects($grade = null);
    public function getByGrade($grade);
}