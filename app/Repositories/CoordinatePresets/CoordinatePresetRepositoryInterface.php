<?php

namespace App\Repositories\CoordinatePresets;

use App\Repositories\RepositoryInterface;

interface CoordinatePresetRepositoryInterface extends RepositoryInterface
{
    public function setDefault($id);
}