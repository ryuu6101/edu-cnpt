<?php

namespace App\Repositories\CoordinatePresets;

use App\Models\CoordinatePreset;
use App\Repositories\BaseRepository;

class CoordinatePresetRepository extends BaseRepository implements CoordinatePresetRepositoryInterface
{
    public function getModel() {
        return CoordinatePreset::class;
    }

    public function setDefault($id) {
        $this->model->where('is_default', true)->update(['is_default' => false]);
        $this->find($id)->update(['is_default' => true]);
        return true;
    }
}