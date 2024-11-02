<?php

namespace App\Repositories\VneduSubjects;

use App\Models\VneduSubject;
use App\Repositories\BaseRepository;

class VneduSubjectRepository extends BaseRepository implements VneduSubjectRepositoryInterface
{
    public function getModel() {
        return VneduSubject::class;
    }

    public function getUnsyncedSubjects($grade = null) {
        if (!$grade) return $this->model->whereNull('subject_id')->get();
        else return $this->model->where('grade', $grade)->whereNull('subject_id')->get();
    }

    public function getByGrade($grade) {
        return $this->model->where('grade', $grade)->get();
    }
}